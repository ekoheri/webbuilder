<div class="container py-3">
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Navbar</th>
                        <th scope="col">Header</th>
                        <th scope="col">Content</th>
                        <th scope="col">Footer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php
                                echo "<ul>";
                                foreach($list_element['navbar'] as $x) {
                                    echo "<li>".$x['id']."</li>";
                                }
                                echo "</ul>";
                            ?>
                        </td>
                        <td>
                        <?php
                                echo "<ul>";
                                foreach($list_element['header'] as $x) {
                                    echo "<li>".$x['id']."</li>";
                                }
                                echo "</ul>";
                            ?>
                        </td>
                        <td>
                        <?php
                                echo "<ul>";
                                foreach($list_element['content'] as $x) {
                                    echo "<li>".$x['id']."</li>";
                                }
                                echo "</ul>";
                            ?>
                        </td>
                        <td>
                        <?php
                                echo "<ul>";
                                foreach($list_element['footer'] as $x) {
                                    echo "<li>".$x['id']."</li>";
                                }
                                echo "</ul>";
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>