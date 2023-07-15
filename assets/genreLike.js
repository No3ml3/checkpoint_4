const totalTypeId = document.getElementById('js-lenght-type');
const totalType = totalTypeId.dataset.set;

for (let i = 1; i <= totalType; i++) {
    document.getElementById("isInFavoriteType" + i).addEventListener("click", addToTypelist);

    function addToTypelist(e) {
        e.preventDefault();

        const watchlistLink = e.currentTarget;
        const link = watchlistLink.href;
        // Send an HTTP request with fetch to the URI defined in the href
        try {
            fetch(link)
                // Extract the JSON from the response
                .then(res => res.json())
                // Then update the icon
                .then(data => {
                    const watchlistIcon = watchlistLink.firstElementChild;
                    if (data.isInFavoriteType) {
                        watchlistIcon.classList.remove("bi-heart"); // Remove the .bi-heart (empty heart) from classes in <i> element
                        watchlistIcon.classList.add("bi-heart-fill"); // Add the .bi-heart-fill (full heart) from classes in <i> element
                    } else {
                        watchlistIcon.classList.remove("bi-heart-fill"); // Remove the .bi-heart-fill (full heart) from classes in <i> element
                        watchlistIcon.classList.add("bi-heart"); // Add the .bi-heart (empty heart) from classes in <i> element
                    }
                });
        } catch (err) {
            console.error(err);
        }
    }
}
