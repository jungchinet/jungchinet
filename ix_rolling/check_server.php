 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>IX Rolling</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="Description" name="Description" content="twitter api rolling ix_rolling facebook rss">
	</head>
	<body>
<table border="1" width="300">
	<col/>
	<col width="80"/>
	<caption>탬플릿 지원환경체크</caption>
	<tr>
		<th>탬플릿</th>
		<th>지원여부</th>
	</tr>
	<tr>
		<td>twitter</td>
		<td>O</td>
	</tr>
	<tr>
		<td>facebook</td>
		<td>O</td>
	</tr>
	<tr>
		<td>gnu4</td>
		<td><?=extension_loaded('mbstring') && function_exists('json_encode')? 'O': 'X'; ?></td>
	</tr>
	<tr>
		<td>xml</td>
		<td><?=extension_loaded('mbstring') && extension_loaded('curl') && extension_loaded('simplexml')? 'O': 'X'; ?></td>
	</tr>
	<tr>
		<td>tf</td>
		<td><?=extension_loaded('mbstring') && extension_loaded('curl') && extension_loaded('simplexml')? 'O': 'X'; ?></td>
	</tr>
</table>

	</body>
</html>
