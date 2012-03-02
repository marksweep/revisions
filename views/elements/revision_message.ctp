<?php
	if (isset($revision)) {
		$this->Html->css(array('/revisions/css/revisions'),'stylesheet', array('inline' => false));
?>
	<div id="RevisionMessage">
	
		<span class="toggle-revision" style="display:none"><a href="#">Toggle Original</a></span>
		
		<span class="revision">You are viewing revision: <?php echo ($revision['Revision']['tag'] ? $revision['Revision']['tag'] : $revision['Revision']['id']); ?> | Created - <?php echo date('F n, Y H:i', strtotime($revision['Revision']['created'])); ?>
		</span>
		<span class="originalnode" style="display:none">You are viewing the original content for node: <?php echo ($node['Node']['title'] ? $node['Node']['title'] : $node['Node']['id']); ?> | Created - <?php echo date('F n, Y H:i', strtotime($node['Node']['created'])); ?></span>	
		
		<span class="push-revision">
    			<?php echo $this->Html->link('Push Revision', array('controller' => 'revisions', 'plugin'=>'revisions', 'action'=>'push', 'admin'=>true, $revision['Revision']['id'])); ?></span>
	</div>
<?php
	}
?>