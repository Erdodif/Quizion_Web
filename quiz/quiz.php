<?php
    require_once "../classes/Quiz.php";
    require_once "../classes/Question.php";
    require_once "../classes/Answer.php";

    $quizId = $_GET["quiz_id"] ?? null;
    $questionId = $_GET["question_id"] ?? null;

    if ($quizId === null) {
        header("Location: ../index.php");
        exit();
    }

    $response_quiz_questions = file_get_contents("http://backend.quizion.hu/adatok/?method=get&table=question&quiz_id=$quizId");
    $response_question_answers = file_get_contents("http://backend.quizion.hu/adatok/?method=get&table=answer&question_id=$questionId");

    $quiz_questions = json_decode($response_quiz_questions);
    $question_answers = json_decode($response_question_answers);
?><!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../style/all.css">
        <link rel="stylesheet" href="../style/quiz.css">
        <link rel="icon" href="../style/quizion.ico">
        <title>Quizion</title>
    </head>
    <body class="body_quiz">
        <?php
            $question = new Question($quiz_questions->data[0]->id, $quiz_questions->data[0]->quiz_id, $quiz_questions->data[0]->content, $quiz_questions->data[0]->no_right_answers, $quiz_questions->data[0]->point);
            for ($i = 0; $i < count($question_answers->data); $i++) {
                $answers_list[$i] = new Answer($question_answers->data[$i]->id, $question_answers->data[$i]->question_id, $question_answers->data[$i]->content, $question_answers->data[$i]->is_right);
            }
        ?>

        <?php require_once "../require_once/header_logo.html" ?>

        <div class="container">
            <div class="time_bar"></div>
            <div class="report">Report</div>
            <div class="quiz_question"><?php echo $question->getContent(); ?></div>

            <?php
                for ($i = 0; $i < count($question_answers->data); $i++) {
                    echo "<div class='quiz_answer'>" . $answers_list[$i]->getContent() . "</div>";
                }
            ?>

            <div class="progress_bar">
                <div class="progress_bar_color"></div>
                <div class="progress_bar_border"></div>
                <div class="progress_bar_text">1/2</div>
            </div>
        </div>

        <?php require_once "../require_once/footer.html"; ?>
    </body>
</html>