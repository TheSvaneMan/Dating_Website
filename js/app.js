/* ---------- Required back-end Services --------- */
const _baseUrl = 'backend/userService.php/';
const _messageUrl = 'backend/messageSystem/B_Messages.php';
/* ---- Global Variables ---- */

// Users displays all users on the database
let _users = [];
// Selected User ID is the ID you select on the home page to match with
let _selectedUserId;
// Message User ID is used to store the ID of the person you want to message
let _messageUserId;
// All messages for the current User
let _messages = [];
// Matches stores all the matches you have.
let _matches = [];

// ========== Test Functions ==========
async function checkActiveUser() {
	const url = _security + '?action=activeUser';
	const response = await fetch(url);
	const data = await response.json();
	result = data;
	console.log(result);
}

async function dataCheck() {
	let username = document.getElementById('usernameLogin').value;
	let password = document.getElementById('passwordLogin').value;

	// declaring a new js object with the form values
	const params = {
		username: username,
		password: password,
	};
	const options = {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json; charset=utf-8',
		},
		body: JSON.stringify(params),
	};
	await fetch('dom.php', options).then((response) => {
		console.log(response);
		let result = response.json();
		console.log(result); // the result is the feedback from server
	});
}

// ========== Data Services ==========
/* Fetch user data from php backend services */
async function loadUsers() {
	const url = _baseUrl + '?action=getUsers';
	const response = await fetch(url);
	const data = await response.json();
	_users = data;
	appendPersons(_users);
}

async function loadMatches() {
	const url = _baseUrl + '?action=getMatches';
	const response = await fetch(url);
	const data = await response.json();
	_matches = data;
	appendMatches(_matches);
}

async function loadMessages() {
	const url = _messageUrl + '?action=getMessages';
	const response = await fetch(url);
	const data = await response.json();
	_messages = data;
	appendMessages(_messages);
}

// ========== Page Control ==========
// Show Home Page
function showUserPage() {
	navigateTo('#/home');
	loadUsers();
}

// Show Sign Up Page
function showSignUpPage() {
	navigateTo('#/');
}

// ========== Application Functions ==========
// Toggle Menu
function toggleMenu() {
	let x = document.getElementById('Menu');
	x.classList.toggle('menuOpen');
}

// Adds persons to the DOM by giving parameter, persons
function appendPersons(users) {
	let htmlTemplate = '';
	for (const user of users) {
		htmlTemplate += /*html*/ `
			<article onclick="showDetails(${user.PK_id})" class="user-item">
			<h3>Name: </h3>${user.firstname}
			<p>Age: ${user.age} </p>
			<p>Interested in: ${user.interestedIn}</p>
			<p>Gender: ${user.gender}</p>
			</article>
		`;
	}
	document.querySelector('#grid-users').innerHTML = htmlTemplate;
}
// Show matches and status
function appendMatches(users) {
	let htmlTemplate = '';
	for (const user of users) {
		htmlTemplate += /*html*/ `
			<article class="user-item">
			<p>User One: ${user.userOne} </p>
			<p>Matched with </p>
			<p>User Two: ${user.userTwo} </p>
			<p>Contact initiated on ${user.matchDate}</p>
			<p>Matched on: (Date both people confirmed)</p>
			<button class="button" onclick="messageUser(${user.userTwo})">Message User</button>
			</article>
		`;
	}
	document.querySelector('#matched-users').innerHTML = htmlTemplate;
}

// Show Selected User Details
async function showDetails(id) {
	_selectedUserId = id;
	localStorage.setItem('selectedUserId', _selectedUserId);
	const selectedUser = _users.find((user) => user.PK_id == id);
	appendPerson(selectedUser);
	navigateTo('#/selectedUser');
}

// append single User / Potential Match
function appendPerson(user) {
	let htmlTemplate = '';
	htmlTemplate += /*html*/ `
			<article class="user-item">
			<h3>Name: ${user.firstname}</h3>
			<p>User Id: ${user.PK_id}</p>
			<p>Age: ${user.age} </p>
			<p>Birthday: ${user.birthday}</p>
			<p>Gender: ${user.gender}</p>
			<p>Interested In: ${user.interestedIn}</p>
			<p>Postal Code: ${user.PostalCode}</p>
			<p>Hobbies: ${user.hobbies}</p>
			<button class="button" onclick="addMatch(${user.PK_id})">Match!</button>
			</article>
		`;
	document.querySelector('#selected-user').innerHTML = htmlTemplate;
}
// Add Match
async function addMatch(selectedId) {
	// declaring a new js object with the form values
	const params = {
		ID: selectedId,
	};
	const options = {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json; charset=utf-8',
		},
		body: JSON.stringify(params),
	};
	await fetch(_baseUrl + '?action=addMatch', options).then((response) => {
		let result = response.json();
	});
}
// ========== Inbox System ==========
// Adds Messages to the Inbox, includes outbox and inbox
function appendMessages(messages) {
	console.log(messages);
	let htmlTemplate = '';
	for (const message of messages) {
		htmlTemplate += /*html*/ `
			<article class="user-item">
				<p>Sent By: ${message.sentby} </p>
				<p>Sent To: ${message.sentto}</p>
				<p>Message: ${message.message} </p>
				<p>Date sent: ${message.created}</p>
			</article>
		`;
	}
	// Filter messages into received and sent
	document.querySelector('#user-messages').innerHTML = htmlTemplate;
}


function toggleChatBox() {
	let chatBox = document.getElementById('chatBox');
	chatBox.style.display = 'none';
}

function messageUser(id) {
	let chatBox = document.getElementById('chatBox');
	chatBox.style.display = 'grid';
	_messageUserId = id;
}

function confirmReceiver() {
	// Prints out the Receiver ID to confirm you selected the right person
	// Debugging purposes
	console.log(_messageUserId);
}

async function sendMessage(receiverID) {
	// Message data collection
	let messageData = document.getElementById('messageData').value;
	// Message Parameters
	const params = {
		receiver: _messageUserId,
		message: messageData,
	};
	const options = {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json; charset=utf-8',
		},
		body: JSON.stringify(params),
	};

	await fetch(_messageUrl + '?action=sendMessage', options).then((response) => {
		let result = response.json();
	});
}
// ========== Loader ==========
/* Show or hides loader by giden parameter: true/false */
function showLoader(show) {
	const loader = document.querySelector('#loader');
	if (show) {
		loader.classList.remove('hide');
	} else {
		loader.classList.add('hide');
	}
}

// ========== Search Function ==========
async function search(searchString) {
	const options = {
		method: 'GET',
	};
	let response = await fetch(
		_baseUrl + '?action=search&value=' + searchString,
		options
	);
	let data = await response.json();
	appendPersons(data);
}

// ========== Create New User ==========
// Create Account
async function createUserEvent() {
	const firstname = document.getElementById('signUpName').value;
	const birthday = document.getElementById('signUpBirthday').value;
	const country = document.getElementById('signUpCountry').value;
	const hobbies = document.getElementById('signUpHobbies').value;
	const PostalCode = document.getElementById('signUpPostalCode').value;
	const gender = document.getElementById('signUpGender').value;
	const age = document.getElementById('signUpAge').value;
	const interestedIn = document.getElementById('signUpInterestedIn').value;
	if (
		firstname &&
		birthday &&
		country &&
		hobbies &&
		PostalCode &&
		gender &&
		age &&
		interestedIn
	) {
		await createUser(
			firstname,
			birthday,
			country,
			hobbies,
			PostalCode,
			gender,
			age,
			interestedIn
		);
	} else {
		alert(' Please fill in all fields.');
	}
}

async function createUser(
	firstname,
	birthday,
	country,
	hobbies,
	postalCode,
	gender,
	age,
	interestedIn
) {
	const newUser = {
		Firstname: firstname,
		Birthday: birthday,
		Hobbies: hobbies,
		Country: country,
		PostalCode: postalCode,
		Gender: gender,
		Age: age,
		InterestedIn: interestedIn,
	};
	console.log(newUser);
	const options = {
		method: 'POST',
		headers: { 'Content-Type': 'application/json; chartype=utf-8' },
		body: JSON.stringify(newUser),
	};

	const response = await fetch(_security + '?action=createUser', options);
	// Wait for server response
	const result = await response.json();
	console.log(result); // Result is the updated users array
	showUserPage(); // Navigate to home page
}

// ========== Filter Functions ==========
// Filters
async function maleOnly() {
	const options = {
		method: 'GET',
	};
	let response = await fetch(_baseUrl + '?action=MaleOnly', options);
	let data = await response.json();
	appendPersons(data);
}
async function femaleOnly() {
	const options = {
		method: 'GET',
	};
	let response = await fetch(_baseUrl + '?action=FemaleOnly', options);
	let data = await response.json();
	appendPersons(data);
}
async function sameAge() {
	const options = {
		method: 'GET',
	};
	let response = await fetch(_baseUrl + '?action=SameAge', options);
	let data = await response.json();
	appendPersons(data);
}

async function differentAge() {
	let age = document.getElementById('selectedAge').value;
	console.log(age);
	const options = {
		method: 'GET',
	};
	let response = await fetch(
		_baseUrl + '?action=DifferentAge&value=' + age,
		options
	);
	let data = await response.json();
	appendPersons(data);
}

// ========== INIT APP ==========
function init() {
	if (location.hash === '#/') {
		showSignUpPage();
	} else if (location.hash === '#/home') {
		showUserPage();
	} else if (location.hash === '#/matches') {
		loadMatches();
	} else if (location.hash === '#/inbox') {
		loadMessages();
	}
}

init();
