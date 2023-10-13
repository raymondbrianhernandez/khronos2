<?php
$emoji_clues = [
    "🍎🐍" => "Eve (or Adam and Eve)",
    "🚢🌧️🕊️🌈" => "Noah",
    "🌳🔥🗣️" => "Moses (Burning Bush)",
    "🧺🌊👑" => "Moses (as a baby in the basket)",
    "🦁🕳️🙏" => "Daniel (in the lion's den)",
    "🐳🙏🏝️" => "Jonah (and the whale)",
    "🌊👣" => "Jesus (walking on water)",
    "🎺🏰🔥" => "Joshua (Battle of Jericho)",
    "🍞🐟👥👥👥👥👥" => "Jesus (feeding the 5,000)",
    "🍷🍞🙏" => "Jesus (Last Supper)",
    "🌌👑🎁" => "The Three Wise Men (or Magi)",
    "🎨🚢🐘🦒🦓" => "Noah (Building the Ark)",
    "💪🦊🔥" => "Samson (Using the foxes with torches)",
    "🗡️👩🎪" => "Jael (Defeating Sisera with a tent peg)",
    "🧂🏞️👀" => "Lot's Wife (Turned into a pillar of salt)",
    "🍷🌾👩" => "Ruth (Gleaning in the fields)",
    "🏰💤🎶" => "King Saul (David playing the harp to soothe him)",
    "🐑👑🎶" => "David (Shepherd, King, Psalmist)",
    "🕊️🔥👥👥👥" => "The Day of Pentecost (Holy Spirit descending)",
    "🐟👨🎣" => "Peter (Fisherman and Apostle)",
    "🍇🍷🌿" => "Canaan (Spies brought back grapes from the Promised Land)",
    "🌊👋🚶‍♂️" => "Moses (Parting the Red Sea)",
    "🦁👑" => "Lion of Judah (A title for Jesus)",
    "🐍🌴" => "The Serpent (Temptation in the Garden of Eden)",
    "🌳👑🌳" => "Nebuchadnezzar (Dream of the tree and his period of madness)",
    "🐦🍞👩" => "Elijah (Fed by ravens)",
    "🌊🚶‍♂️🌊" => "Peter (Walking on water towards Jesus)",
    "🌌🔭📖" => "Daniel (Interpreting King Nebuchadnezzar's dream)",
    "🏠🔝🌞🌛" => "Joshua (Battle of Gibeon, sun and moon stood still)",
    "🐟💰👄" => "Peter (Finding a coin in the fish's mouth for the temple tax)",
    "👠🌾👑" => "Esther (Becoming queen and saving her people)",
    "👴🔥🌊" => "Elijah (Calling down fire and taken to heaven in a chariot)",
    "👦🌈👑" => "Joseph (Dreamer with a coat of many colors)",
    "🌿🕊️🚢" => "Noah (Olive branch brought by dove)",
    "👑💤🌌" => "King Nebuchadnezzar (Dream of the statue)",
    "🍞🍷👦" => "Melchizedek (King of Salem, blessing Abraham)",
    "👦🐑🔥" => "Isaac (Almost sacrificed by Abraham)",
    "👟🌊" => "Israelites (Crossing the Jordan River on dry ground)",
    "👦🔥👦🔥👦🔥" => "Shadrach, Meshach, and Abednego (Fiery furnace)",
    "👦🦁" => "Samson (Killing a lion)",
    "👦👧🍞🍷" => "Boy with five loaves and two fish",
    "👦👑🗡️" => "David (Killing Goliath)",
    "👦🎻" => "David (Playing the harp)",
    "👦🌾" => "Boaz (Ruth's kinsman redeemer)",
    "👦🐟🍞" => "Andrew (Bringing the boy with five loaves and two fish to Jesus)",
    "👦🌌🌽" => "Pharaoh (Dream of seven fat and seven lean cows)",
    "👦🌌🌾" => "Pharaoh (Dream of seven healthy and seven withered stalks of grain)",
    "👦🐪🌟" => "Balaam (and his talking donkey seeing the angel)",
    "👦🔥🗡️" => "Gideon (Testing God with the fleece and leading a small army with torches)",
    "👦👦👦🍷" => "Paul, Silas, and Timothy (Missionary journeys)"
];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emoji Bible Flashcards</title>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Patrick Hand', cursive;
            background-color: #FFC1CC;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .flashcard {
            width: 300px;
            height: 300px;
            background-color: #FFF;
            border-radius: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 4rem;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s;
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .flashcard:hover {
            transform: scale(1.05);
        }

        button {
            padding: 10px 20px;
            font-size: 1.5rem;
            background-color: #FFD700;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 10px;
        }

        button:hover {
            background-color: #FFC700;
        }

        .answer {
            font-size: 1.5rem;
            margin-bottom: 20px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="answer" id="answerDisplay"></div>
    <div class="flashcard" id="flashcard">
        <div class="emoji-display" id="emojiDisplay"></div>
    </div>
    <button onclick="showAnswer()">Show Answer</button>
    <button onclick="nextEmoji()">Next</button>

    <script>
        const emojiClues = <?php echo json_encode($emoji_clues); ?>;
        let emojiKeys = Object.keys(emojiClues);
        let currentEmoji = getRandomEmoji();
        let setsPlayed = 0;

        document.getElementById('emojiDisplay').innerText = currentEmoji;

        function showAnswer() {
            const answer = emojiClues[currentEmoji];
            document.getElementById('answerDisplay').innerText = answer;
            document.getElementById('answerDisplay').style.display = 'block';
        }

        function nextEmoji() {
            if (setsPlayed < 4) {
                currentEmoji = getRandomEmoji();
                document.getElementById('emojiDisplay').innerText = currentEmoji;
                document.getElementById('answerDisplay').style.display = 'none';
                setsPlayed++;
            } else {
                alert('Mahalo for playing! 🌺');
                location.reload();
            }
        }

        function getRandomEmoji() {
            const randomIndex = Math.floor(Math.random() * emojiKeys.length);
            const randomEmoji = emojiKeys[randomIndex];
            emojiKeys.splice(randomIndex, 1); // Remove the used emoji to avoid repetition
            return randomEmoji;
        }
    </script>
</body>
</html>
