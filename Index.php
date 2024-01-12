<?php

// Define multiple sets of words for different games
$games = array(
    array(
        "supermarket" => "A place to buy groceries",
        "programming" => "Writing code to create software",
        "development" => "The process of building and improving software",
        "apache" => "A popular web server",
        "university" => "An institution of higher education",
        "rayjemiel" => "A creative twist on a name"
    ),
    array(
        "mountain" => "A large landform that rises prominently above its surroundings",
        "ocean" => "A vast expanse of saltwater",
        "forest" => "A large area covered chiefly with trees and undergrowth",
        "desert" => "A dry, barren area of land",
        "constellation" => "A group of stars forming a recognizable pattern",
        "galaxy" => "A system of millions or billions of stars, together with gas and dust"
    ),
    // Add more games as needed
);

$gameIndex = isset($_POST['gameIndex']) ? $_POST['gameIndex'] : 0;
$strArray = $games[$gameIndex];

$index = isset($_POST['index']) ? $_POST['index'] : 0;
$score = isset($_POST['score']) ? $_POST['score'] : 0;
$start_time = isset($_POST['start_time']) ? $_POST['start_time'] : time();

// Initialize $message1
$message1 = "";

// Check if a guess has been submitted
if (isset($_POST['guess'])) {
    // Check if the guess is correct
    if ($_POST['guess'] == array_keys($strArray)[$index]) {
        $message1 = "<h1>You guessed right!</h1></br>";
        $index++;
        $score++;
    } else {
        $message1 = "<h1>You guessed wrong!</h1></br>";
    }
}

// Set shuffled word and clue based on the current game and index
$shuffledWord = ($index < count($strArray)) ? str_shuffle(array_keys($strArray)[$index]) : "";
$clue = ($index < count($strArray)) ? $strArray[array_keys($strArray)[$index]] : "";

$elapsed_time = time() - $start_time;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess the Word Game</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
        }

        form {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            font-size: 18px;
            display: block;
        }

        input {
            padding: 10px;
            font-size: 16px;
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        button {
            padding: 12px 20px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            max-width: 400px;
            margin: 0 auto;
            position: relative;
        }

        .close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        #play-again {
            background-color: #2196F3;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        #play-again:hover {
            background-color: #0b7dda;
        }
    </style>
</head>
<body>

<div style="background-color: #333; padding: 10px;">
    <h1 style="color: #fff;">Guess the Word Game</h1>
</div>

<?php echo $message1; ?>
<b>Try to guess the shuffled word: </b>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label for="guess">Enter your guess:</label>
    <input type="text" id="guess" name="guess" />
    <input type="hidden" name="index" value="<?php echo $index; ?>">
    <input type="hidden" name="score" value="<?php echo $score; ?>">
    <input type="hidden" name="start_time" value="<?php echo $start_time; ?>">
    <input type="hidden" name="gameIndex" value="<?php echo $gameIndex; ?>">
    <button type="submit" name="submit" value="submit">Guess</button>
</form>

<!-- Modal -->
<div class="modal" id="myModal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Guess Result</h2>
        <p><?php echo $message1; ?></p>
        <p><b>Shuffled Word: </b><?php echo $shuffledWord; ?></p>
        <p><b>Clue: </b><?php echo $clue; ?></p>
        <?php if ($index < count($strArray)) : ?>
            <button onclick="nextWord()">Next Word</button>
        <?php else : ?>
            <p>Game Over! Your Score: <?php echo $score; ?></p>
            <p>Elapsed Time: <?php echo $elapsed_time; ?> seconds</p>
            <button id="play-again" onclick="resetGame()">Play Again</button>
        <?php endif; ?>
    </div>
</div>

<!-- Game Selector -->
<div style="margin-top: 20px;">
    <h2>Choose a Game</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <select name="gameIndex" onchange="this.form.submit()">
            <?php for ($i = 0; $i < count($games); $i++) : ?>
                <option value="<?php echo $i; ?>" <?php echo ($i == $gameIndex) ? 'selected' : ''; ?>>
                    Game <?php echo $i + 1; ?>
                </option>
            <?php endfor; ?>
        </select>
    </form>
</div>

<script>
    function openModal() {
        document.getElementById('myModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    function nextWord() {
        closeModal();
        document.forms[0].submit();
    }

    function resetGame() {
        closeModal();
        window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>';
    }

    // Open the modal when there is a guess
    <?php if (isset($_POST['guess'])) : ?>
    openModal();
    <?php endif; ?>
</script>

</body>
</html>
