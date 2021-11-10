<?php
    require_once "osztalyok/Quiz.php";
    require_once "osztalyok/Question.php";
    require_once "osztalyok/Answer.php";

    $response_quiz_questions = file_get_contents("http://10.147.20.1/adatok/?method=get&table=question&quiz_id=1");
    $response_question_answers = file_get_contents("http://10.147.20.1/adatok/?method=get&table=answer&question_id=1");

    $quiz_questions = json_decode($response_quiz_questions);
    $question_answers = json_decode($response_question_answers);
?><!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="quiz.css">
        <title>Quizion</title>
    </head>
    <body>
        <?php
            $kerdes = new Question($quiz_questions->data[0]->id, $quiz_questions->data[0]->quiz_id, $quiz_questions->data[0]->content, $quiz_questions->data[0]->no_right_answers, $quiz_questions->data[0]->point);
            for ($i = 0; $i < count($question_answers->data); $i++) {
                $valasz[$i] = new Answer($question_answers->data[$i]->id, $question_answers->data[$i]->question_id, $question_answers->data[$i]->content, $question_answers->data[$i]->is_right);
            }
        ?>

        <div class="egesz">
            <div class="report">Report</div>
            <div class="kerdes"><?php echo $kerdes->getContent(); ?></div>

            <?php
                for ($i = 0; $i < count($question_answers->data); $i++) {
                    echo "<div class='valasz'>" . $valasz[$i]->getContent() . "</div>";
                }
            ?>

            <div class="also_sor">
                <span class="ido">01:25</span><div class="progress_bar">10 / 10</div>
                <div class="score">35 Pont</div>
            </div>
        </div>

        <div class="footer">
            <h4>© Copyright - quizion.hu - Minden jog fenntartva.</h4>
            <a href="#" target="jog">Jogi-, adatvédelmi nyilatkozat.</a>
        </div>
    </body>
</html>
