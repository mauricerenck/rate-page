
const initThumbRatings = () => {
    const thumbs = document.querySelectorAll('.rate-page__thumbs .thumb');
    const slug = thumbs[0].getAttribute('data-slug')
    const storageRatings = window.localStorage.getItem('page-thumb-ratings');
    let loading = false

    const sendThumbRating = (rating, slug) => {
        const url = '/' + slug + '/rate-page/thumb/' + rating
        const clientRating = setRating(rating)
        loading = true

        if (clientRating === false) {
            return false
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(clientRating)
        })
            .then(() => {
                loading = false
            })
            .catch(error => {
                console.log(error)
            })
    }

    const getRating = () => {
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

    const setRating = (rating) => {
        const selector = (rating > 0) ? '.up' : '.down'
        const newRatings = []
        let ratings = []
        let updated = false
        let prevRating = null

        if (storageRatings !== null) {
            ratings = JSON.parse(storageRatings)
        }

        ratings.forEach(existingRating => {
            if (existingRating.slug === slug) {
                prevRating = existingRating.rating
                existingRating.rating = rating
                updated = true
            }

            newRatings.push(existingRating)
        })

        if (!updated) {
            newRatings.push({
                slug: slug,
                rating: rating,
            })
        }

        window.localStorage.setItem('page-thumb-ratings', JSON.stringify(newRatings))
        const thumb = document.querySelector('.rate-page__thumbs .thumb' + selector)
        const currentlySelectedThumb = document.querySelector('.rate-page__thumbs .thumb.checked')

        if (!thumb) {
            return false
        }

        if (currentlySelectedThumb !== null) {
            currentlySelectedThumb.classList.remove('checked')
            const amount = currentlySelectedThumb.querySelector('.amount')
            amount.innerHTML = parseInt(amount.innerHTML) - 1
        }

        thumb.classList.add('checked')
        const amount = thumb.querySelector('.amount')
        amount.innerHTML = parseInt(amount.innerHTML) + 1

        if (rating === prevRating) {
            return false
        }

        return {
            slug: slug,
            rating: rating,
            updated: updated,
            prevRating: prevRating
        }
    }

    const currentRating = getRating();

    thumbs.forEach((thumb) => {
        const rating = thumb.getAttribute('data-id')

        if (currentRating == rating) {
            thumb.classList.add('checked')
        }

        thumb.addEventListener('click', () => {
            if (!loading) {
                sendThumbRating(rating, slug)
            }
        })
    })


}