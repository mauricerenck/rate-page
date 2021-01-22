const initStarRatings = () => {
    const stars = document.querySelectorAll('.rate-page__stars .star');
    const slug = stars[0].getAttribute('data-slug')
    let loading = false


    const getRating = () => {
        const storageRatings = window.localStorage.getItem('page-star-ratings');
        if (storageRatings !== null) {
            const ratings = JSON.parse(storageRatings)

            let rating = ratings.filter(page => {
                return page.slug === slug
            })

            if (rating.length > 0) {
                return rating[0].rating
            }
        }

        return 0
    }

    const sendRating = (rating, slug) => {
        const clientRating = setRating(rating)

        if (!clientRating) {
            return false
        }

        fetch(`/${slug}/rate-page/stars`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(clientRating)
        })
            .then(() => {
                setUserRating()
                loading = false
            })
            .catch(error => {
                console.log(error)
            })
    }

    const setRating = (rating) => {
        const storageRatings = window.localStorage.getItem('page-star-ratings');
        const newStorageRatings = []

        let ratings = []
        let updated = false
        let prevRating = null

        if (storageRatings !== null) {
            ratings = JSON.parse(storageRatings)

            ratings.forEach(existingRating => {
                if (existingRating.slug === slug) {
                    prevRating = existingRating.rating
                    existingRating.rating = rating
                    updated = true
                }

                newStorageRatings.push(existingRating)
            })
        }

        if (!updated) {
            newStorageRatings.push({
                slug: slug,
                rating: rating,
            })
        }

        window.localStorage.setItem('page-star-ratings', JSON.stringify(newStorageRatings))

        if (rating === prevRating) {
            return false
        }

        return {
            slug: slug,
            rating: rating,
            prevRating: prevRating
        }
    }


    const setUserRating = () => {
        const starDomElements = document.querySelectorAll('.rate-page__stars .rating .star');
        const currentRating = getRating();

        if (!starDomElements || currentRating === 0) {
            return false;
        }

        starDomElements.forEach(element => {
            element.classList.remove('checked')
            if (element.dataset.id <= currentRating) {
                element.classList.add('checked');
                element.classList.add('user');
            }
        });
    }

    stars.forEach((thumb) => {
        const rating = thumb.getAttribute('data-id')

        thumb.addEventListener('click', () => {
            if (!loading) {
                sendRating(rating, slug)
            }
        })
    })

    setUserRating()
}

initStarRatings()