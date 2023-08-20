<div class="card">
    <div class="card-body">
        <button class="btn btn-primary" onclick="ShowModal('<?php echo $element_type?>')">Add Element <?php echo $element_type?></button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Elements</th>
                    <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 0;
                $last_id = $element_type.'-0';
                foreach($element_data as $el) { 
                    $last_id = $el['id'];
                    $i++;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>
                        <?php echo $el['id'];?>
                        <p id="IdPImg-<?php echo $el['id']?>" hidden><?php echo $el['image'];?></p>
                        <p id="IdPHtml-<?php echo $el['id']?>" hidden><?php echo htmlentities($el['html']);?></p>
                    </td>
                    <td>
                        <a href="#" onclick="EditElement('<?php echo $element_type?>', '<?php echo $el['id']?>')">Edit</a>&nbsp;
                        <a href="<?php echo BASE_URL?>/index.php/admin/delete/<?php echo $element_type.'/'.$el['id']?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php 
                }//end for 
                ?>
                <tr>
                    <td colspan="2"><strong>Jumlah element <?php echo $element_type; ?></strong></td>
                    <td>
                        <strong><?php echo $i ?></strong>
                        <p id="idLastElement-<?php echo $element_type; ?>" hidden><?php echo $last_id; ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>