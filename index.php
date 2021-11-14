<?php
    require_once "classes/Quiz.php";
    require_once "classes/Question.php";
    require_once "classes/Answer.php";

    $response_quizes = file_get_contents("http://backend.quizion.hu/adatok/?method=get&table=quiz");
    $response_quiz_first_question_answers = file_get_contents("http://backend.quizion.hu/adatok/?method=get&table=answer&question_id=1");

    $quizes = json_decode($response_quizes);
    $quiz_first_question_answers = json_decode($response_quiz_first_question_answers);
?><!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/all.css">
        <link rel="stylesheet" href="style/quiz_list.css">
        <link rel="icon" href="style/quizion.ico">
        <title>Quizion</title>
    </head>
    <body>
        <?php
            for ($i = 0; $i < count($quizes->data); $i++) {
                $quizes_list[$i] = new Quiz($quizes->data[$i]->id, $quizes->data[$i]->header, $quizes->data[$i]->description, $quizes->data[$i]->active);
            }
        ?>

        <?php require_once "require_once/header_logo.html" ?>

        <div class="container">
            <?php for ($i = 0; $i < count($quizes->data); $i++) { ?>
                <div class="quiz_list_div">
                    <h2 class="quiz_list_header"><?php echo $quizes_list[$i]->getHeader(); ?></h2>
                    <p><?php echo $quizes_list[$i]->getDescription(); ?></p>
                    <a href="quiz/quiz.php?quiz_id=<?php echo $quizes_list[$i]->getId(); ?>&question_id=<?php echo 1; ?>">Játék</a>
                </div>
            <?php } ?>
        </div>

        <?php require_once "require_once/footer.html"; ?>
    </body>
</html>
