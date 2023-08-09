<html>
<head>
    <title>Web Builder Spec API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
<div class="container py-3">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <p>Get API Key</p>
                    <p><input class="form-control" readonly type="text" value ="<?php echo $api_key ?>" /></p>
                    <p>Pasang API Key ini di Header ketika melakukan request ke Server</p>
                </div>
            </div>
        </div>
    </div> 
    <div class="row py-5">
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
                                echo "<p>ID Template Element Navbar</p>";
                                echo "<ul>";
                                foreach($list_element['navbar'] as $x) {
                                    echo "<li>".$x['id']."</li>";
                                }
                                echo "</ul>";
                            ?>
                        </td>
                        <td>
                        <?php
                                echo "<p>ID Template Element Header</p>";
                                echo "<ul>";
                                foreach($list_element['header'] as $x) {
                                    echo "<li>".$x['id']."</li>";
                                }
                                echo "</ul>";
                            ?>
                        </td>
                        <td>
                        <?php
                                echo "<p>ID Template Element Content</p>";
                                echo "<ul>";
                                foreach($list_element['content'] as $x) {
                                    echo "<li>".$x['id']."</li>";
                                }
                                echo "</ul>";
                            ?>
                        </td>
                        <td>
                        <?php
                                echo "<p>ID Template Element Footer</p>";
                                echo "<ul>";
                                foreach($list_element['footer'] as $x) {
                                    echo "<li>".$x['id']."</li>";
                                }
                                echo "</ul>";
                            ?>
                        </td>
                        <td>
                            <?php
                                echo "<p>ID Template Page </p>";
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
    <div class="row">
        <div class="col">
            <h2>Spec API</h2>
            <ol>
                <li>
                    <p>Menampilkan daftar element HTML</p>
                    <p>[URL Backend Server]/api/elements/[PARAMETER JENIS ELEMENT]</p>
                    <p>Method : GET</p>
                    <p>contoh localhost : http://localhost:8080/api/elements/navbar</p>
                </li>
            </ol>    
        </div>    
    </div>
</div>
</body>
</html>