<div class="new-type-header">
    <p class="numer-handlowy">
        <label>
            id:
            <span><?php echo $id;?></span>
        </label>
        <span><?php    echo $numer; ?></span>
    </p>
    <p  class="ikony-handlowe">
        
        <span class="edit-span">
        <?php 
            echo $this->Html->link(
                '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 
                array('controller' => 'orders', 'action' => 'edit', $id),
                array('class' => 'edlink',  'escape' =>false)
            ); ?>
        </span>
        <span class="pdf-span">
        <?php
            echo $this->Html->link(
                '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>', 
                array('controller' => 'orders', 'action' => 'view', $id, 'ext' => 'pdf'),
                array('class' => 'pdflink',  'escape' =>false)
            );
        ?>
        </span>
    </p>
    <p class="daty-handlowe"><label>termin:</label><?php    echo $termin; ?></p>
</div>