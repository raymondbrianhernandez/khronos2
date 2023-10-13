<?php
    // PHP logic goes here
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open in Safari</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }

        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <p>If you want to add a website shortcut icon (often referred to as a "web clip") to your iPhone's home screen, follow these steps:</p>
    <ol>
        <li><strong>Launch Safari</strong>:
            <ul>
                <li>Open the Safari browser on your iPhone.</li>
            </ul>
        </li>
        <li><strong>Navigate to the Website</strong>:
            <ul>
                <li>Go to khronos.pro</li>
            </ul>
        </li>
        <li><strong>Share Button</strong>:
            <ul>
                <li>Once the website loads, tap on the share button. It looks like a rectangle with an arrow pointing upwards.</li>
            </ul>
        </li>
        <li><strong>Add to Home Screen</strong>:
            <ul>
                <li>In the share menu, scroll until you find the "Add to Home Screen" option and tap on it.</li>
            </ul>
        </li>
        <li><strong>Name the Shortcut</strong>:
            <ul>
                <li>You'll have the option to name the shortcut. This will be the label under the icon on your home screen.</li>
            </ul>
        </li>
        <li><strong>Add</strong>:
            <ul>
                <li>Tap "Add" in the top-right corner.</li>
            </ul>
        </li>
    </ol>
    <p>Now, the website shortcut will be on your iPhone's home screen. Tapping on it will open the website in Safari.</p>

    <p>If the website has defined a specific icon for iOS devices, that icon will be used. Otherwise, a miniaturized version of the webpage will be the default icon.</p>

    <p>Remember, this process creates a shortcut to the website and not an actual app. It's a quick way to access frequently visited websites without needing to open Safari and typing in the URL every time.</p>

    <button onclick="openInSafari()">Open in Safari</button>

    <script>
        function openInSafari() {
            var newWindow = window.open('https://khronos.pro', '_blank');
            if (!newWindow || newWindow.closed || typeof newWindow.closed == 'undefined') {
                alert('Please copy the link and open it in Safari for the best experience.');
            }
        }
    </script>
</body>

</html>
