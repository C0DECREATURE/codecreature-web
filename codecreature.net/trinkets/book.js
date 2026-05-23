(()=>{
	// all books turn page on click
	books = document.getElementsByClassName('book');
	for (let i = 0; i < books.length; i++) {
		books[i].addEventListener('click',()=>{ turnBookPage(books[i]); });
	}
	
	// turn page of given book
	function turnBookPage(book) {
		pages = book.getElementsByClassName('pageInner');
		flippedPages = book.getElementsByClassName('flip');
		// if less than 2 inner pages, do nothing
		if (pages.length <= 2) {
		// if all pages flipped, unflip all but first page
		} else if (pages.length - 1 <= flippedPages.length) {
			for (let i = 0; i < pages.length - 1; i++) {
				pages[i].classList.remove('flip');
			}
		// if not all pages flipped, flip the first unflipped page
		} else {
			for (let i = pages.length - 1; i > 0; i--) {
				if (!pages[i].classList.contains('flip')) {
					pages[i].classList.add('flip');
					pages[i-1].classList.add('flip');
					break;
				}
			}
		}
	}
})();