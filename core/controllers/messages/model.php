<?php

	/*
		update messages set m_readed = null, m_hide_in_user=null,m_hide_in_sender=null;
		update messages_contacts set mc_hide_in_sender=null,mc_hide_in_user=null;
	*/

	namespace Core\Controllers\Messages;

	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;

	class Model extends ParentModel{

		/** @var $this */
		private static $instance;

		/** @var Cache */
		protected $cache;

		private $users_table_join_query = "if(mc_receiver_id=%receiver_id%,mc_sender_id=u_id,mc_receiver_id=u_id)";

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->cache->key('messages');
		}

		public function countContacts($receiver_id){
			$result = $this->select('COUNT(mc_id) as total')
				->from('messages_contacts')
				->where("if(`mc_sender_id`=%receiver_id%,isnull(mc_hide_in_sender),isnull(mc_hide_in_user)) and (`mc_receiver_id`=%receiver_id% or `mc_sender_id`=%receiver_id%)")
				->data('%receiver_id%',$receiver_id)
				->get()
				->itemAsArray();

			return $result['total'];
		}

		/**
		 * @TODO: 1. переписать вложенный SELECT count(m_id), т.к. 4сек на 1М записях, вместо 0.006сек
		 * @TODO: 1.1.	Возможно на UPDATE total=(
		 * @TODO:				select count(m_id)
		 * @TODO:					from messages
		 * @TODO:					where m_contact_id=mc_id
		 * @TODO:						and isnull(m_readed)
		 * @TODO:						and m_receiver_id=%receiver_id% order by m_id
		 * @TODO:				) WHERE this;
		 * @TODO: 		при добавлении нового сообщения
		 * @TODO: 1.2. создать новые поля mc_sender_total и mc_receiver_total
		 *
		 * @param $receiver_id
		 * @param $limit
		 * @param $offset
		 * @param string $order
		 * @return array
		 */

		public function getContacts($receiver_id,$limit,$offset,$order='mc_last_message_id'){
			$where_query = "";
			$where_query .= "if(`mc_sender_id`=%receiver_id%,isnull(mc_hide_in_sender),isnull(mc_hide_in_user))";
			$where_query .= " and (`mc_receiver_id` = %receiver_id% or `mc_sender_id` = %receiver_id%)";

			$result = $this->select(
				"u_id",
				"p_micro",
				"p_small",
				"u_gender",
				"u_first_name",
				"u_full_name",
				"u_id",
				"m_sender_id",
				"mc_id",
				"u_date_log",
				"m_content",
				"m_date_created",
				"m_date_created",
				"m_date_created",
				"m_date_created"
//				, $select_nested_query
				, "if(mc_receiver_id=%receiver_id%,mc_receiver_total,mc_sender_total) as total"
				)
				->from('messages_contacts')
				->join('users FORCE INDEX (PRIMARY)',$this->users_table_join_query)
				->join('messages FORCE INDEX (PRIMARY)',"mc_last_message_id=m_id")
				->join('photos FORCE INDEX (PRIMARY)',"u_avatar_id=p_id")
				->where($where_query)
				->data('%receiver_id%',$receiver_id)
				->limit($limit)
				->offset($offset)
				->order(/*'total DESC',*/$order)		// ??? total
				->sort('DESC')
				->get()
				->allAsArray();

			return $result;
		}

		public function getContactById($user_id,$contact_id){
			$result = $this->select()
				->from('messages_contacts')
				->join('users FORCE INDEX (PRIMARY)',$this->users_table_join_query)
				->join('photos FORCE INDEX (PRIMARY)',"p_id=u_avatar_id")
				->where("`mc_id`=%contact_id% and if(`mc_sender_id`=%receiver_id%,isnull(mc_hide_in_sender),isnull(mc_hide_in_user))")
				->data('%contact_id%',$contact_id)
				->data('%receiver_id%',$user_id)
				->get()
				->itemAsArray();

			return $result;
		}

		public function countMessagesByContactId($user_id,$contact_id){
			$result = $this->select('COUNT(m_id) as total')
				->from('messages')
				->where("`m_contact_id`=%contact_id% and if(m_sender_id=%user_id%,isnull(m_hide_in_sender),isnull(m_hide_in_user))")
				->data('%contact_id%',$contact_id)
				->data('%user_id%',$user_id)
				->get()
				->itemAsArray();

			return $result['total'];
		}

		public function getMessagesByContactId($user_id,$contact_id,$limit,$offset){
			$result = $this->select()
				->from('messages')
				->where("`m_contact_id`=%contact_id% and if(m_sender_id=%user_id%,isnull(m_hide_in_sender),isnull(m_hide_in_user))")
				->data('%contact_id%',$contact_id)
				->data('%user_id%',$user_id)
				->limit($limit)
				->offset($offset)
				->order('m_id')
				->sort('DESC')
				->get()
				->allAsArray();

			return $result;
		}

		public function updateMessagesStatusRead($total,$sender_id,$where_query){
			$result = $this->update('messages')
				->field('m_readed',true)
				->query('mc_sender_total',"if(mc_sender_id=%sender_id%,mc_sender_total-{$total},mc_sender_total)")
				->query('mc_receiver_total',"if(mc_receiver_id=%sender_id%,mc_receiver_total-{$total},mc_receiver_total)")
				->join('messages_contacts',"mc_id=m_contact_id")
				->data('%sender_id%',$sender_id)
				->where($where_query)
				->get()
				->rows();

			return $result;
		}

		public function getMessageById($message_id){
			$result = $this->select()
				->from('messages')
				->where("`m_id`=%message_id%")
				->data('%message_id%',$message_id)
				->get()
				->itemAsArray();

			return $result;
		}

		public function deleteMessage($user_id,$message_id){
			$result =$this->update('messages')
				->query('m_hide_in_sender',"if(m_sender_id=%user_id%,1,m_hide_in_sender)")
				->query('m_hide_in_user',"if(m_receiver_id=%user_id%,1,m_hide_in_user)")
				->data('%user_id%',$user_id)
				->data('%message_id%',$message_id)
				->where("`m_id`=%message_id%")
				->get()
				->rows();

			return $result;
		}

		public function deleteContact($user_id,$contact_id){
			$result = $this->update('messages_contacts')
				->query('mc_hide_in_sender',"if(mc_sender_id=%user_id%,1,mc_hide_in_sender)")
				->query('mc_hide_in_user',"if(mc_receiver_id=%user_id%,1,mc_hide_in_user)")
				->query('m_readed',"if(m_receiver_id=%user_id%,1,m_readed)")
				->join('messages FORCE INDEX (PRIMARY)',"mc_id=m_contact_id")
				->where("`mc_id`=%contact_id%")
				->data('%contact_id%',$contact_id)
				->data('%user_id%',$user_id)
				->get()
				->rows();

			return $result;
		}















	}














