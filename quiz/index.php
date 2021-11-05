<?php
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
            $kiir_quiz = json_decode($response_quiz);
            $kiir_question = json_decode($response_question);
            $kiir_answer = json_decode($response_answer);
        ?>

        <div class="egesz">
            <div class="report">Report</div>
            <!--<div class="felso_sor">
                <h1 class="tema"><?php //echo $kiir_quiz->data[1]->header; ?></h1>
            </div>-->

            <div class="kerdes"><?php echo $kiir_question->data[1]->content; ?></div>
            <div class="egyseg valasz"><?php echo $kiir_answer->data[1]->content; ?></div>
            <div class="egyseg valasz"><?php echo $kiir_answer->data[2]->content; ?></div>
            <div class="egyseg valasz"><?php echo $kiir_answer->data[3]->content; ?></div>
            <div class="egyseg valasz"><?php echo $kiir_answer->data[4]->content; ?></div>
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
