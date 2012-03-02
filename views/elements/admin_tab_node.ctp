<?php
// Add the revisions css file
$this->Html->css(array('/revisions/css/revisions'),'stylesheet', array('inline' => false));
?>

<?php
    echo $this->Form->input('Revision.current_user', array('type'=>'hidden', 'value'=>$this->Session->read('Auth.User.id')));
    
    // List revisions for this node
    
    if (isset($this->data['Revisions'][0])) {
    ?>
    	<table>
    		<thead>
    <?php
    			// Grab the header fields and make them pretty
    			$headers = array_keys($this->data['Revisions'][0]['Revision']);
    		
    			foreach ($headers as $key => $value) {
    				switch ($value) {
    					case 'md5':
    					case 'body':
    					case 'is_current':
    						unset($headers[$key]);
    						break;
    					case 'user_id':
    						$headers[$key] = 'User';
    						break;
    					default:
    						$headers[$key] = Inflector::humanize($value);
    				
    				}
    			}
    			
    			// Add Column for Edit / Preview / Promote admin links
    			$headers[] = 'Actions';
    			
    			echo $this->Html->tableHeaders($headers);
    
    ?>
    		</thead>
    		<tbody>
    <?php
    	// Loop through the revisions and display as a table
    	foreach ($this->data['Revisions'] as $revision) {
    		
    		$revision_id = $revision['Revision']['id'];
    		
    		unset($revision['Revision']['md5']);
    		unset($revision['Revision']['body']);
    		
    		$revision['Revision']['title'] = $this->Html->link($revision['Revision']['title'], '/page/' . $this->data['Node']['slug'] . '/' . $revision_id, array('target'=>'_blank'));
    		$revision['Revision']['user_id'] = $revision['User']['username'];
    		$revision['Revision']['created'] = date('m-d-y H:i:s', strtotime($revision['Revision']['created']));
    		
    		// Special class for current revision
    		$is_current = $revision['Revision']['is_current'];
    		if ($is_current) {
    			$revision['Revision']['id'] = array($revision_id, array('class'=>'is-current'));
    		}
    		
    		unset($revision['Revision']['is_current']);
    		
    		$delete_link 	= '';
    		$push_link 		= 'Current Revision';
    		$edit_link		= '';
    		if (!$is_current){
    			// Allow deletes for non-current items
    			$delete_link 	= $this->Html->link('Delete', array('controller' => 'revisions', 'plugin'=>'revisions', 'action'=>'delete', 'admin'=>true, $revision_id));
    			$push_link 		= $this->Html->link('Push', array('controller' => 'revisions', 'plugin'=>'revisions', 'action'=>'push', 'admin'=>true, $revision_id));
    			$edit_link 		= $this->Html->link('Edit', array('controller' => 'revisions', 'plugin'=>'revisions', 'action'=>'edit', $revision_id));
    		}
    		
    		// Actions
    		$revision['Revision']['action'] = 
    			$push_link . ' ' . 
    			$edit_link . ' ' . 
    			$delete_link . ' '  
    			
    			;
    		
    		echo $this->Html->tableCells($revision['Revision']);
    	
    	}
    
    ?>
    		</tbody>
    	</table>
    	
    <?php
    } else {
    
    	// No current revisions
    
    }
    
    // Add revision box
?>
	<h3 id="AddRevision" style="margin-top:20px; border-bottom: dotted 1px #CCC">Add New Revision</h3>
		<?php echo $this->Form->input('Revision.tag'); ?>
		<?php echo $this->Form->input('Revision.title'); ?>
		<?php echo $this->Form->input('Revision.excerpt', array('label' => 'Excerpt', 'type' => 'textarea')); ?>
		<?php echo $this->Form->input('Revision.body', array('label' => 'Body', 'type' => 'textarea')); ?>



<script type="text/javascript">
// <![CDATA[
$(document).ready(function() {

	// Apply a style to the whole row for is-current revisions
	$('#node-revisions .is-current').parent().addClass('is-current');

});
// ]]>
</script>	