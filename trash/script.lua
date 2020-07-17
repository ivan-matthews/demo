--[[
	// Вызвать с помощью РНР
	$lua = new \Lua();
	$lua->eval(file_get_contents(fx_path('trash/script.lua')));
	$lua->test_lua('lua test');
	// базовое инфо: https://ru.wikipedia.org/wiki/Lua
]]

function other_function(blabla)
	print(blabla);
	return true;
end

function test_lua(entered_data)
	other_function('some data');
	print('LUA say: ' ..  entered_data);
	print('<br>');
	for i=0,10 do
    	print('Next string: ' .. entered_data .. ', iterator position: ' .. i);
		print('<br>');
	end
	return true;
end
