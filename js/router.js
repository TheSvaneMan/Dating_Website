/* ---- Global Variables ---- */
let _loggedIn = false;
// Security features should run first in routing script, create
// nav guards
const _security = 'backend/security.php';
/* ---- Page Routes ---- */
const _routes = {
	'#/': 'login',
	'#/signUp': 'signUp',
	'#/inbox': 'inbox',
	'#/selectedUser': 'selectedUser',
	'#/matches': 'matches',
	'#/home': 'home',
	'#/about': 'about',
	'#/create': 'create',
	'#/user': 'user',
	'#/update': 'update',
	'#/404': '404',
};
const _pages = document.querySelectorAll('.page');
const _basePath = location.pathname.replace('index.php', ''); // Remove index.html from path
const _navLinks = document.querySelectorAll('nav a');

/* Changing display to none for all pages */
function hideAllPages() {
	for (const page of _pages) {
		page.style.display = 'none';
	}
}

/* Navigating SPA to specific page for a given path */
function navigateTo(path) {
	window.history.pushState({}, path, _basePath + path);
	showPage(path);
}

function showPage(path) {
	hideAllPages(); // Hides all pages
	document.querySelector(`#${_routes[path]}`).style.display = 'block';
	setActiveTab(path); // Sets the UI of nav to highlight active tab
}

/* Sets active menu item by given path */
function setActiveTab(path) {
	for (const link of _navLinks) {
		if (path === link.getAttribute('href')) {
			link.classList.add('activeLink');
		} else {
			link.classList.remove('activeLink');
		}
	}
}

/* Attaching event to nav links and preventing default anchor link event */
function attachNavLinkEvents() {
	const navLinks = document.querySelectorAll('.nav-link');
	for (const link of _navLinks) {
		link.addEventListener('click', function (event) {
			const path = link.getAttribute('href');
			navigateTo(path);
			event.preventDefault();
		});
	}
}

/* Initializing the router */
function initRouter() {
	attachNavLinkEvents();
	window.addEventListener('popstate', () => showPage(location.hash)); // Change page back and forth when using a browser
	let path = '#/'; //default path
	if (_routes[location.hash]) {
		path = location.hash;
	}
	navigateTo(path);
}

// ========== Check if User is Logged In ==========
// Security Feature
async function checkUserStatus() {
	// Check Log in Status of Users
	const url = _security + '?action=userStatus';
	const response = await fetch(url);
	const data = await response.json();
	// alert("Status: " + data.status + ", Message: " + data.message);
	if (data.status == 200) {
		_loggedIn = true;
	} else if (data.status == 400) {
		_loggedIn = false;
	}
}

initRouter();
