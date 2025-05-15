const boardId = 'b24ec04e2284a5ea699b0a40';
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

