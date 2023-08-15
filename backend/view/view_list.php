<div class="container py-3">
    <div class="row">
        <div class="col">
        <h2>Daftar Element HTML</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Navbar</th>
                        <th scope="col">Header</th>
                        <th scope="col">Content</th>
                        <th scope="col">Footer</th>
                        <th scope="col">Page</th>
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
                        <td>
                        <?php
                                echo "<ul>";
                                foreach($list_element['page'] as $x) {
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