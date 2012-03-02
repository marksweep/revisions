
<h2 id="EditRevision">Edit Revision</h3>
<?php echo $this->Form->create('Revision'); ?>
<?php echo $this->Form->input('Revision.tag'); ?>
<?php echo $this->Form->input('Revision.title'); ?>
<?php echo $this->Form->input('Revision.excerpt', array('label' => 'Excerpt', 'type' => 'textarea')); ?>
<div class="node-body">
	<?php echo $this->Form->input('Revision.body', array('label' => 'Body', 'type' => 'textarea', 'class' => 'content' )); ?>
</div>

<div class="buttons">
	<?php echo $this->Form->submit('Save'); ?>
	<?php echo $this->Html->link('Cancel', array(
		'controller' => 'nodes',
		'plugin' => false,
		'action' => 'edit',
		$this->data['Revision']['node_id'] . '#node-revisions'
	)); ?>
</div>
<?php echo $this->Form->end(); ?>
		