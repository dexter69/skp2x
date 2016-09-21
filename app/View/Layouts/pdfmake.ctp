<!DOCTYPE html>
<html lang='pl'>
<head>
  <meta charset='utf-8'>
  <title>my first pdfmake example</title>
  <?php
  echo $this->Html->script(array('lib/pdfmake.min', 'lib/vfs_fonts')); 
  
  echo $this->fetch('script');
  ?>  
</head>
<body>
    <?php
        echo $this->fetch('content'); 
        echo $this->fetch('scriptBottom');
    ?>
</body>
</html>