############################################################################################
#	class Perl{
#		private $input_data;
#		public function eval($perl_code,$as_array=false){
#			$perl_code = str_replace('\'',"\"",$perl_code);
#			if($as_array){
#				exec("perl -e '{$perl_code}' {$this->input_data}",$response_data);
#				print_r($response_data);
#			}else{
#				$response_data = exec("perl -e '{$perl_code}' {$this->input_data}");
#				print($response_data);
#			}
#			return $response_data;
#		}
#		public function vars(...$input_variable){
#			$this->input_data = implode(' ',$input_variable);
#			return $this;
#		}
#		public function file($file_path,$as_array=false){
#			if($as_array){
#				exec("perl {$file_path} {$this->input_data}",$response_data);
#				print_r($response_data);
#			}else{
#				$response_data = exec("perl {$file_path} {$this->input_data}");
#				print($response_data);
#			}
#			return $response_data;
#		}
#	}
#
#	$pl = new Perl();
#	$pl->vars(json_encode($_SESSION));
#	$pl->eval(file_get_contents(fx_path('trash/script.pl')));
#	$pl->file(fx_path('trash/script.pl'));
#############################################################################################

sub test_function{
	print $a;
	return true;
}

$count = 0;
$a = "some data ";

for($count..10){
	test_function($a) . print "iterator position: $count <br>";
	$count++;
}
print join("<br>", @ARGV);
print 'ok';
print "<hr>";