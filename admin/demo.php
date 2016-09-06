<?php
	$htmlData = '';
	if (!empty($_POST['content1'])) {
		if (get_magic_quotes_gpc()) {
			$htmlData = stripslashes($_POST['content1']);
		} else {
			$htmlData = $_POST['content1'];
		}
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>KindEditor PHP</title>
	<link rel="stylesheet" href="view/editor/default/default.css" />
	<link rel="stylesheet" href="view/editor/code/prettify.css" />
	<script charset="utf-8" src="view/editor/kindeditor.js"></script>
	<script charset="utf-8" src="view/editor/zh_CN.js"></script>
	<script charset="utf-8" src="view/editor/code/prettify.js"></script>
	
	<script>
		KindEditor.ready(function(K) {
			var editor1 = K.create('textarea[name="content1"]', {
				cssPath : 'view/editor/code/prettify.css',
				uploadJson : 'view/editor/upload_json.php',
				fileManagerJson : 'view/editor/file_manager_json.php',
				allowFileManager : true,
				afterCreate : function() {
					var self = this;
					K.ctrl(document, 13, function() {
						self.sync();
						K('form[name=form1]')[0].submit();
					});
					K.ctrl(self.edit.doc, 13, function() {
						self.sync();
						K('form[name=form1]')[0].submit();
					});
				}
			});
			prettyPrint();
		});
	</script>
</head>
<body> 
	<?php echo $htmlData; ?>
	<form name="example" method="post" action="demo.php">
		<textarea name="content1" style="width:700px;height:200px;visibility:hidden;"><?php echo htmlspecialchars($htmlData); ?></textarea>
		<br />
		<input type="submit" name="button" value="提交内容" /> (提交快捷键: Ctrl + Enter)
	</form>
</body>
</html>

