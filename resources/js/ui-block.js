module.exports = {
	block: (e) => {
		const c = `
			<div class="blockui-blocker position-absolute w-100 h-100 top-0 start-0 d-flex align-items-center justify-content-center animate__animated animate__fadeIn animate__faster" style="background-color: rgba(255, 255, 255, .6); backdrop-filter: blur(1px);z-index: 9999;">
				<div class="spinner-border text-primary" role="status"></div>
			</div>`;

		e = (typeof e === 'undefined' ? 'body' : e)

		let t = e.target ? e.target.closest('.blockui') : document.querySelector(e);
			t.classList.add('position-relative');
			t.innerHTML += c;
	},

	unblock: () => {
		let a = document.querySelector('.blockui-blocker');
			t = a.closest('.blockui')
		a.classList.add('animate__fadeOut')
		a.addEventListener('animationend', () => {
			a.remove()
			t.classList.remove('position-relative')
		})
	}
}
