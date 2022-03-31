<?php
    date_default_timezone_set("Asia/Vladivostok");

    const MESSAGES_JSON = "messages.json";
    const USERS = [
        "andrewsha" => "durka",
        "borewsha" => "shizer",
        "transcendentall" => "1111",
        "denis" => "1234",
        "bedpled" => "uwu",
        "alexoff13" => "DNS",
        "liss" => "13579",
        "dotdot" => "loh",
        "kent" => "dota2",
        "hoper" => "gachi",
        "hostridet" => "koocaghei6moo9eegieyah4thi7LoNgo",
        "dudoserovich" => "dudoser",
        "romka" => "los"
    ];

    function get_html_message(string $date, string $user, string $message): string {
        return "<div class='message__info'>
                    <div>$user</div>
                    <div>$date</div>
                </div>
                <div class='message_text'>$message</div>
                <hr>";
    }


    $authorized = false;
    if ($_GET['login'] == null && $_GET['password'] == null) {
        $user = "не авторизован";
    } else if (!key_exists($_GET['login'], USERS) || USERS[$_GET['login']] != $_GET['password']) {
        $user = "авторизация прошла безуспешно";
    } else {
        $user = $_GET['login'];
        $authorized = true;
    }

    if (file_exists(MESSAGES_JSON)) {
        $messages = json_decode(file_get_contents(MESSAGES_JSON), true);
    } else {
        $messages = [
            "messages" => []
        ];
    }

    if ($authorized && $_GET["message"] != null) {
        $messages["messages"][] = [
            "date" => date("d.m.Y H:i"),
            "user" => $user,
            "message" => $_GET["message"]
        ];
        file_put_contents(MESSAGES_JSON, json_encode($messages));
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
    <link href="static/styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="auth">
            <form id="authForm" class="auth__form">
                <div class="mb-3">
                    <label for="login" class="form-label">Логин</label>
                    <input placeholder="<?=key(USERS); ?>"
                           name="login" class="form-control" id="login">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input placeholder="<?=USERS[key(USERS)]; ?>"
                           name="password" type="password" class="form-control" id="password">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Войти</button>
                </div>
            </form>
        </div>
        <div class="user">
            <div class="user__label">Текущий пользователь:</div>
            <div class="user__name"><?=$user; ?></div>
        </div>
        <div class="messages__wrapper">
            <div class="messages" id="messages" data-bs-spy="scroll" data-bs-offset="0" tabindex="0">
                <?php
                    foreach ($messages["messages"] as $message) {
                        echo get_html_message($message["date"], $message["user"], $message["message"]);
                    }
                ?>
            </div>
        </div>
        <?php
            if ($authorized) {
                echo
                '<div class="input__message">
                    <label><textarea placeholder="Сообщение" id="message" class="input__message__textarea"></textarea></label>
                    <button id="send" type="button" class="btn btn-primary">Отправить</button>
                </div>';
            }
        ?>
    </div>

    <script src="static/main.js"></script>
</body>
</html>