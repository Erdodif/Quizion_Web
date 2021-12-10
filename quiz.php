<?php
    require_once "classes/Question.php";
    require_once "classes/Answer.php";

    $quiz_id = $_GET["quiz_id"] ?? null;
    $question_get = $_GET["question_get"] ?? null;

    if ($quiz_id === null || $question_get === null || empty($quiz_id) || empty($question_get)) {
        header("Location: quiz_list.php");
        exit();
    }

    $quiz_question = json_decode(file_get_contents("http://quizion.hu/api/quiz/$quiz_id/question/$question_get"));
    $question_answers = json_decode(file_get_contents("http://quizion.hu/api/quiz/$quiz_id/question/$question_get/answers"));

    if ($quiz_question === null || $question_answers === null || empty($quiz_question) || empty($question_answers)) {
        header("Location: quiz_end.php");
        exit();
    }

    $question = new Question($quiz_question->id, null, $quiz_question->content, $quiz_question->no_right_answers, $quiz_question->point);
    for ($i = 0; $i < count($question_answers); $i++) {
        $answers_list[$i] = new Answer($question_answers[$i]->id, null, $question_answers[$i]->content, null);
    }

    $question_get++;
    $count_questions = $question_get - 1;
    $questions_count = count(json_decode(file_get_contents("http://quizion.hu/api/quiz/$quiz_id/questions")));

?><!DOCTYPE html>
<html lang="hu">
    <head>
        <?php require_once "includes/head.html"; ?>
        <link rel="stylesheet" href="style/css/quiz.css">
        <title>Quizion Kvíz</title>
    </head>
    <body class="body_quiz">
        <div id="loader_div"><div id="loader"></div></div>
        <?php require_once "includes/header_logo.html"; ?>

        <div class="container">
            <div class="time_bar"></div>
            <div class="report">Report</div>
            <div class="quiz_question"><?php echo $question->getContent(); ?></div>

            <?php for ($i = 0; $i < count($question_answers); $i++) { ?>
                <a href="quiz.php?quiz_id=<?php echo $quiz_id; ?>&question_get=<?php echo $question_get; ?>">
                    <div class="quiz_answer"><?php echo $answers_list[$i]->getContent(); ?></div>
                </a>
            <?php } ?>

            <div class="progress_bar">
                <div class="progress_bar_color" style="width: <?php echo $count_questions / $questions_count * 100; ?>%;"></div>
                <div class="progress_bar_border"></div>
                <div class="progress_bar_text"><?php echo $count_questions; ?>/<?php echo $questions_count; ?></div>
            </div>
        </div>

        <?php require_once "includes/footer.html"; ?>
        <script src="includes/loader.js"></script>
    </body>
</html>
