<!-- index.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Infinite Scroll</title>
    <style>
        .post {
            border: 1px solid #ccc;
            margin: 10px 0;
            padding: 10px;
        }

        #loader {
            text-align: center;
            padding: 20px;
            display: none;
        }
    </style>
</head>

<body>

    <div id="post-container">
        <?php
        require 'vendor/autoload.php';

        use Medoo\Medoo;

        $db = new Medoo([
            'type' => 'mysql',
            'host' => 'localhost',
            'database' => 'instagram_clone',
            'username' => 'root',
            'password' => ''
        ]);

        $posts = $db->select("posts", "*", [
            "ORDER" => ["created_at" => "DESC"],
            "LIMIT" => [0, 10]
        ]);

        foreach ($posts as $post) {
            echo "<div class='post'>";
            echo "<h3>" . $post['id'] . "</h3>";
            echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";
            echo "</div>";
        }
        ?>
    </div>

    <div id="loader">Loading...</div>

    <script>
        let offset = 2;
        const limit = 2;
        let loading = false;

        function loadMore() {
            if (loading) return;
            loading = true;
            document.getElementById('loader').style.display = 'block';

            fetch(`load_more.php?offset=${offset}&limit=${limit}`)
                .then(res => res.text())
                .then(html => {
                    if (html.trim().length === 0) {
                        window.removeEventListener('scroll', onScroll);
                    } else {
                        document.getElementById('post-container').insertAdjacentHTML('beforeend', html);
                        offset += limit;
                    }
                })
                .finally(() => {
                    loading = false;
                    document.getElementById('loader').style.display = 'none';
                });
        }

        function onScroll() {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 400) {
                loadMore();
            }
        }

        window.addEventListener('scroll', onScroll);
    </script>

</body>

</html>