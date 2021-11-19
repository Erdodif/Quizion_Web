<?php
    require_once "classes/Quiz.php";
    require_once "classes/Question.php";
    require_once "classes/Answer.php";

    $quizId = $_GET["quiz_id"] ?? null;
    $questionId = $_GET["question_id"] ?? null;

    if ($quizId === null) {
        header("Location: quiz_list.php");
        exit();
    }
    // közös
    //$response_quiz_questions = file_get_contents("http://backend.quizion.hu/adatok/?method=get&table=question&quiz_id=$quizId");
    //$response_question_answers = file_get_contents("http://backend.quizion.hu/adatok/?method=get&table=answer&question_id=$questionId");

    // saját
    $response_quiz_questions = file_get_contents("http://localhost/backend.quizion.hu/?method=get&table=question&quiz_id=$quizId");
    $response_question_answers = file_get_contents("http://localhost/backend.quizion.hu/?method=get&table=answer&question_id=$questionId");

    $quiz_questions = json_decode($response_quiz_questions);
    $question_answers = json_decode($response_question_answers);

    $question = new Question($quiz_questions->data[0]->id, $quiz_questions->data[0]->quiz_id, $quiz_questions->data[0]->content, $quiz_questions->data[0]->no_right_answers, $quiz_questions->data[0]->point);
    for ($i = 0; $i < count($question_answers->data); $i++) {
        $answers_list[$i] = new Answer($question_answers->data[$i]->id, $question_answers->data[$i]->question_id, $question_answers->data[$i]->content, $question_answers->data[$i]->is_right);
    }
?><!DOCTYPE html>
<html lang="hu">
    <head>
        <?php require_once "require_once/head.html"; ?>
        <link rel="stylesheet" href="style/css/quiz.css">
        <title>Quizion Quiz</title>
    </head>
    <body class="body_quiz">
        <?php require_once "require_once/header_logo.html"; ?>

        <div class="container">
            <div class="time_bar"></div>
            <div class="report">Report</div>
            <div class="quiz_question"><?php echo $question->getContent(); ?></div>

            <?php for ($i = 0; $i < count($question_answers->data); $i++) { ?>
                <div class="quiz_answer"><?php echo $answers_list[$i]->getContent(); ?></div>
            <?php } ?>

            <div class="progress_bar">
                <div class="progress_bar_color"></div>
                <div class="progress_bar_border"></div>
                <div class="progress_bar_text">1/2</div>
            </div>
        </div>

        <?php require_once "require_once/footer.html"; ?>
    </body>
</html>
