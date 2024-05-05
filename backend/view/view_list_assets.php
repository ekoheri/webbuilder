<div class="card">
    <div class="card-body">
        <button class="btn btn-primary" onclick="ShowModalAsset()">Add Assets</button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Assets</th>
                    <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $i = 0;
                foreach($data_assets as $la) { 
                    $i++;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>
                        <?php echo $la; ?>
                    </td>
                    <td>
                        <a href="<?php echo BASE_URL?>/index.php/admin/delete_asset/<?php echo $la?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php 
                }//end for 
                ?>
                <tr>
                    <td colspan="2"><strong>Jumlah Asset <?php echo ""; ?></strong></td>
                    <td>
                        <strong><?php echo count($data_assets);?></strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>