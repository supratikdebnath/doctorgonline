// JavaScript Document
window.addEvent("domready", function() {

			/* Example 5 */
			var gallery5 = new slideGallery($$("div.gallery")[0], {
				steps: 1,
				mode: "circle",
				autoplay: true,
				duration: 2000
			});
			/* Example 6 */
			var gallery6 = new slideGallery($$("div.gallery")[5], {
				steps: 2,
				mode: "circle",
				autoplay: true,
				autoplayOpposite: true,
				duration: 3000,
				direction: "vertical"
			});
			/* Example 7 */
			var gallery7 = new slideGallery($$("div.gallery")[6], {
				steps: 2,
				duration: 2000,
				autoplay: true,
				paging: true
			});
			/* Example 8 */
			var gallery8 = new slideGallery($$("div.gallery")[7], {
				steps: 1,
				direction: "vertical",
				paging: true,
				onStart: function(current, visible, length) {
					$$("span.info")[7].innerHTML = $$("div.gallery")[7].getElements("img")[current].title;
				},
				onPlay: function(current, visible, length) {
					$$("span.info")[7].innerHTML = $$("div.gallery")[7].getElements("img")[current].title;
				}
			});
			/* Example 9 */
			var gallery9 = new slideGallery($$("div.gallery")[8], {
				steps: 1,
				mode: "circle",
				current: 4,
				speed: 0
			});
			/* Example 10 */
			var gallery10 = new slideGallery($$("div.gallery")[9], {
				steps: 2,
				speed: 700,
				transition: Fx.Transitions.Sine.easeInOut,
				onStart: function(current, visible, length) {
					$$("span.info")[9].innerHTML = parseInt(current+1) + "-" + parseInt(visible+current) + " from " + length;
				},
				onPlay: function(current, visible, length) {
					$$("span.info")[9].innerHTML = parseInt(current+1) + "-" + parseInt(visible+current) + " from " + length;
				}
			});
			/* Example 11 */
			var gallery11 = new slideGallery($$("div.gallery")[10], {
				steps: 1
			});
			/* Example 12 */
			var gallery12 = new fadeGallery($$("div.gallery")[11], {
				speed: 400,
				paging: true,
				autoplay: true,
				duration: 2000,
				onStart: function(current, visible, length) {
					$$("span.info")[11].innerHTML = parseInt(current+1) + " from " + length;
				},
				onPlay: function(current, visible, length) {
					$$("span.info")[11].innerHTML = parseInt(current+1) + " from " + length;
				}
			});
		});