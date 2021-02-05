<html>
<head>
    <?php echo css('/media/plugins/mauricerenck/ratePage/stars.css'); ?>
</head>
<body>

<h1><?= $page->title() ?></h1>
<?php snippet('thumb-rating'); ?>
<hr>
<?php snippet('star-rating'); ?>
</body>
</html>