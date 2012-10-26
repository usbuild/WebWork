<?php foreach ($posts as $post): ?>
<?php var_dump($post->content); ?>
<?php endforeach; ?>
<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)) ?>