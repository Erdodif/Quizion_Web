<?php
    require_once "classes/Question.php";
    require_once "classes/Answer.php";

    $quiz_id = $_GET["quiz_id"] ?? null;
    $question_get = $_GET["question_get"] ?? null;

    if ($quiz_id === null) {
        header("Location: quiz_list.php");
        exit();
    }

    $quiz_question = json_decode(file_get_contents("http://quizion.hu/api/quiz/$quiz_id/question/$question_get"));
    $question_answers = json_decode(file_get_contents("http://quizion.hu/api/quiz/$quiz_id/question/$question_get/answers"));

    $question = new Question($quiz_question->id, null, $quiz_question->content, $quiz_question->no_right_answers, $quiz_question->point);
    for ($i = 0; $i < count($question_answers); $i++) {
        $answers_list[$i] = new Answer($question_answers[$i]->id, null, $question_answers[$i]->content, null);
    }

?><!DOCTYPE html>
<html lang="hu">
    <head>
        <?php require_once "include/head.html"; ?>
        <link rel="stylesheet" href="style/css/quiz.css">
        <title>Quizion Kvíz</title>
    </head>
    <body class="body_quiz">
        <div id="loader_div"><div id="loader"></div></div>
        <?php require_once "include/header_logo.html"; ?>

        <div class="container">
            <div class="time_bar"></div>
            <div class="report">Report</div>
            <div class="quiz_question"><?php echo $question->getContent(); ?></div>

            <?php for ($i = 0; $i < count($question_answers); $i++) { ?>
                <div class="quiz_answer"><?php echo $answers_list[$i]->getContent(); ?></div>
            <?php } ?>

            <div class="progress_bar">
                <div class="progress_bar_color"></div>
                <div class="progress_bar_border"></div>
                <div class="progress_bar_text">1/2</div>
            </div>
        </div>

        <?php //require_once "include/footer.html"; ?>
        <script src="include/loader.js"></script>
    </body>
</html>
