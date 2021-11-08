<?php
    require_once "osztalyok/Quiz.php";
    require_once "osztalyok/Question.php";
    require_once "osztalyok/Answer.php";

    $response_quiz = file_get_contents("http://10.147.20.1/adatok/index.php?table=quiz");
    $response_question = file_get_contents("http://10.147.20.1/adatok/index.php?table=question");
    $response_answer = file_get_contents("http://10.147.20.1/adatok/index.php?table=answer");
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
            $quiz = json_decode($response_quiz);
            $question = json_decode($response_question);
            $answer = json_decode($response_answer);

            $kerdes = new Question($question->data[0]->id, $question->data[0]->quiz_id, $question->data[0]->content, $question->data[0]->no_right_answers, $question->data[0]->point);
            // 4 helyett a kérdésnek hány válaszlehetősége van
            // data[$i] helyett a megfelelő kérdés válaszai
            for ($i = 0; $i < 4; $i++) {
                $valasz[$i] = new Answer($answer->data[$i]->id, $answer->data[$i]->question_id, $answer->data[$i]->content, $answer->data[$i]->is_right);
            }
        ?>

        <div class="egesz">
            <div class="report">Report</div>
            <div class="kerdes"><?php echo $kerdes->getContent(); ?></div>

            <?php
                /*
                $quiz_id = $quiz->data[0]->id;
                if ($quiz_id == 1) {
                    // 4 helyett a kérdésnek hány válaszlehetősége van
                    for ($i = 0; $i < 4; $i++) {
                        echo "<div class='valasz'>" . $answer->data[$i]->content . "</div>";
                    }
                }
                */

                // 4 helyett a kérdésnek hány válaszlehetősége van
                for ($i = 0; $i < 4; $i++) {
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
