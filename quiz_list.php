<?php
    require_once "classes/Quiz.php";

    $quizes = json_decode(file_get_contents("http://127.0.0.1:8000/api/quizes"));

    for ($i = 0; $i < count($quizes); $i++) {
        $quizes_list[$i] = new Quiz($quizes[$i]->id, $quizes[$i]->header, $quizes[$i]->description);
    }

?><!DOCTYPE html>
<html lang="hu">
    <head>
        <?php require_once "includes/head.html"; ?>
        <link rel="stylesheet" href="style/css/quiz_list.css">
        <title>Quizion Kvízek Listája</title>
    </head>
    <body>
        <div id="loader_div"><div id="loader"></div></div>
        <?php require_once "includes/header_logo.html"; ?>

        <div class="container">
            <?php for ($i = 0; $i < count($quizes); $i++) { ?>
                <div class="quiz_list_div">
                    <h2 class="quiz_list_header"><?php echo $quizes_list[$i]->getHeader(); ?></h2>
                    <p class="quiz_list_description"><?php echo $quizes_list[$i]->getDescription(); ?></p>
                    <a href="quiz.php?quiz_id=<?php echo $quizes_list[$i]->getId(); ?>&question_get=1">Játék</a>
                </div>
            <?php } ?>
        </div>

        <?php require_once "includes/footer.html"; ?>
        <script src="includes/loader.js"></script>
    </body>
</html>
