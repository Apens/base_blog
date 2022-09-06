// traitement LoginUser
function loginUser(event){
    event.preventDefault();
    // console.log(event);
    let url = '/base_blog/backend/loginScript.php';

    let data = new FormData(event.target);
    let value = Object.fromEntries(data.entries());
    console.log(data, event.target, value);

    fetch(url, {
        method: 'POST',
        body: JSON.stringify(value),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        }
    })
        .then((response)=> response.json())
        .then((data)=> {
            sessionStorage.setItem('user', JSON.stringify(data.response.user));
            // console.log(data.response.user)
            window.location.reload();
        })


}

// traitement register User

function registerUser(event){
    event.preventDefault();
    // console.log(event);
    let url = '/base_blog/backend/signUpScript.php';

    let data = new FormData(event.target);
    let value = Object.fromEntries(data.entries());
    console.log(data, event.target, value);

    fetch(url, {
        method: 'POST',
        body: JSON.stringify(value),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        }
    })
        .then((response)=> response.json())
        .then((data)=> {
            sessionStorage.setItem('user', JSON.stringify(data.response.user));
            // console.log(data.response.user)
            window.location.reload();
        })


}