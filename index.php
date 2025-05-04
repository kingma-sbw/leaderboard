<!DOCTYPE html>
<html lang="de_ch">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Board</title>
    <script type="module">
        const boardId = 'f3476188bb8b7e1ab757ae2c';
        const baseUrl = `https://leaderboard.sbw.media/${boardId}`;
        const boardUrl = `${baseUrl}/BoardScore`;
        const scoreUrl = `${baseUrl}/LastScores`;
        
        async function getBoardScore() {
            try {
                const response = await fetch(boardUrl);
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
            } catch (error) {
                console.error('Error fetching board score:', error);
                return;
            }
            const response = await fetch(scoreUrl);
            const data = await response.json();
            const scores = data.resources;
            const template = document.getElementById('score-template');
            const table = document.querySelector('table>tbody');
            table.innerHTML = '';

            scores.forEach((score, index) => {
                const clone = template.content.cloneNode(true);
                const [name, scoreValue, date] = clone.querySelectorAll('td');
                name.textContent = score.leader_name;
                scoreValue.textContent = score.score;
                date.textContent = score.date;
                table.appendChild(clone);
            });
        }
        async function setBoardScore() {
            let response;
            const payload = {
                board_id: boardId,
                leader_name: document.getElementById('name').value,
                score: +document.getElementById('score').value,
                date: new Date() 
            };
            try {
                response = await fetch(boardUrl, {
                    method: 'POST',
                    body: JSON.stringify(payload),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
            } catch (error) {
                console.error('Error setting board score:', error);
                return;
            }
            const data = await response.json();
            getBoardScore();
        }
        document.getElementById('set').addEventListener('click', setBoardScore);
        getBoardScore();

    </script>
</head>

<body>
    <input type="text" id="name" placeholder="Name">
    <input type="number" id="score" placeholder="Score">
    <button id="set">Set Score</button>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Score</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <template id="score-template">
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </template>
</body>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }
</style>
<details>
    <summary>set your board id</summary>
    <pre>
    const boardId = 'Your board id';
    const baseUrl = `https://<?= $_SERVER['SERVER_NAME']?>/${boardId}`;
</pre>
</details>
<details>
    <summary>get scoreboard</summary>
    <pre>
    const scoreUrl = `${baseUrl}/LastScores`;
    async function getBoardScore() {
        try {
            const response = await fetch(boardUrl);
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
        } catch (error) {
            console.error('Error fetching board score:', error);
            return;
        }
        const data = await response.json();
        const scores = data.resources;
        console.log(scores);
    }
</pre>
</details>
<details>
    <summary>set score</summary>
    <pre>
    const boardUrl = `$baseUrl/BoardScore`;
    async function setBoardScore() {
        let response;
        const payload = {
            board_id: boardId,
            leader_name: "Johannes",
            score: 10000,
            date: new Date()
        };
        try {
            response = await fetch(boardUrl, {
                method: 'POST',
                body: JSON.stringify(payload),
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
        } catch (error) {
            console.error('Error setting board score:', error);
            return;
        }
        const data = await response.json();
        getBoardScore();
    }
    </pre>
</details>

<details>
    <summary>get your own board id</summary>
    <style lang="css">
        form {
            display: flex;
            flex-direction: column;
            width: 200px;
        }

        input {
            margin-bottom: 10px;
            padding: 5px;
        }

        button {
            padding: 5px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
        
    </style>
    <form action="board-request.php" method="post">
        <input type="text" name="board_name" placeholder="Boardname" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">Get Board ID</button>
    </form>

</details>
</html>
