<?php
    require_once "classes/Quiz.php";
    require_once "classes/Question.php";
    require_once "classes/Answer.php";

    // közös
    //$response_quizes = file_get_contents("http://backend.quizion.hu/adatok/?method=get&table=quiz");
    //$questions = json_decode(file_get_contents("http://backend.quizion.hu/adatok/?method=get&table=question"));

    // saját
    $response_quizes = file_get_contents("http://localhost/backend.quizion.hu/?method=get&table=quiz");
    $questions = json_decode(file_get_contents("http://localhost/backend.quizion.hu/?method=get&table=question"));

    $quizes = json_decode($response_quizes);

    for ($i = 0; $i < count($quizes->data); $i++) {
        $quizes_list[$i] = new Quiz($quizes->data[$i]->id, $quizes->data[$i]->header, $quizes->data[$i]->description, $quizes->data[$i]->active);
    }

    for ($i = 0; $i < count($questions->data); $i++) {
        $questions_list[$i] = new Question($questions->data[$i]->id, $questions->data[$i]->quiz_id, $questions->data[$i]->content, $questions->data[$i]->no_right_answers, $questions->data[$i]->point);
    }

    $index = 0;
    foreach ($quizes_list as $quiz) {
        foreach ($questions_list as $question) {
            if ($quiz->getId() === $question->getQuizId()) {
                $quizes_questions_matrix[$quiz->getId()][$index] = $question->getId();
                $index++;
            }
        }
        $index = 0;
    }
?><!DOCTYPE html>
<html lang="hu">
    <head>
        <?php require_once "require_once/head.html"; ?>
        <link rel="stylesheet" href="style/css/quiz_list.css">
        <title>Quizion Kvízek Listája</title>
    </head>
    <body>
        <?php require_once "require_once/header_logo.html"; ?>

        <div class="container">
            <?php for ($i = 0; $i < count($quizes->data); $i++) { ?>
                <div class="quiz_list_div">
                    <h2 class="quiz_list_header"><?php echo $quizes_list[$i]->getHeader(); ?></h2>
                    <p class="quiz_list_description"><?php echo $quizes_list[$i]->getDescription(); ?></p>
                    <a href="quiz.php?quiz_id=<?php echo $quizes_list[$i]->getId(); ?>&question_id=<?php echo $quizes_questions_matrix[$i + 1][0]; ?>">Játék</a>
                </div>
            <?php } ?>
        </div>

        <?php require_once "require_once/footer.html"; ?>
    </body>
</html>
