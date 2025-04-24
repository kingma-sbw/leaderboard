# Leaderboard api

## installation

```sql
create database leaderboard;
create user 'leader_user'@'%' identified by 'password';
grant all privileges on leaderboard.* to 'leader_user'@'%';
flush privileges;
use leaderboard;
```

execute scripts in db

## preparation

* get your uuid
* get the main api url

## setup

```js
const boardId = '2572690c-20f1-11f0-84e4-7a20bef12a9e';
const boardUrl = `https://leaderboard.example.com/${boardId}/BoardScore`;
const ScoreUrl = `https://leaderboard.example.com/${boardId}/LastScores`;
```



## Get

```js
async function getBoardScore() {
    const response = await fetch(boardUrl);
    const data = await response.json();
    const scores = data.resources;
    scores.forEach( score => console.log(score) );
}
```

## Set

```js
async function setBoardScore() {
    const payload = {
        board_id: boardId,
        leader_name: "Jki",
        score: 5000000,
        date: formatDate(new Date()) // format(new Date(),'yyyy-MM-dd HH:mm:ss')
    };
    const response = await fetch(boardUrl, {
        method: 'POST',
        body: JSON.stringify(payload)
    });
    const data = await response.json();
}
```

where formatDate

```js
function formatDate(date) {
    const formatter = new Intl.DateTimeFormat('en-CA', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    });

    const parts = formatter.formatToParts(date);

    const formattedDate = `${parts.find(p => p.type === 'year').value}-` +
        `${parts.find(p => p.type === 'month').value}-` +
        `${parts.find(p => p.type === 'day').value} ` +
        `${parts.find(p => p.type === 'hour').value}:` +
        `${parts.find(p => p.type === 'minute').value}:` +
        `${parts.find(p => p.type === 'second').value}`;

    return formattedDate;
}
```