const initThumbRatings = () => {
    const ratingContainer = document.querySelector('.rate-page__thumbs');
    const thumbs = ratingContainer.querySelectorAll('.thumb');

    const slug = ratingContainer.dataset.slug
    const baseUrl = ratingContainer.dataset.baseUrl

    let loading = false


    const updateThumbRating = (rating) => {
        const url = `${baseUrl}/ratepage/vote/thumb`

        if (loading === true) {
            return;
        }

        loading = true;

        const userRating = processUserRating(rating);

        const newRating = {
            slug: slug,
            rating: rating,
            updated: updated,
            prevRating: prevRating
        }

        // const clientRating = setRating(rating)

        // loading = true

        // if (clientRating === false) {
        //     return false
        // }

        // fetch(url, {
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'application/json',
        //     },
        //     body: JSON.stringify(clientRating)
        // })
        //     .then(() => {
        //         loading = false
        //     })
        //     .catch(error => {
        //         console.log(error)
        //     })
    }


    const processUserRating = (newRating) => {
        const userRating = getUserRating();

        switch (newRating) {
            case 0: break;
            case -1: break;
            case 1: break;
        }

        // update localstorage
        // update thumbs in html 


    }

    const setRating = (rating) => {
        const storageRatings = window.localStorage.getItem('page-thumb-ratings');
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

    const getUserRating = () => {
        const storageRatings = window.localStorage.getItem('page-thumb-ratings');

        if (!storageRatings) {
            return 0;
        }

        const ratings = JSON.parse(storageRatings)

        const userRating = ratings.find(page => {
            return page.slug === slug
        })

        if (!userRating) {
            return 0
        }


        return userRating.rating
    }



    thumbs.forEach((thumb) => {
        const rating = thumb.dataset.id;

        // if (userRating == rating) {
        //     thumb.classList.add('checked')
        // }

        thumb.addEventListener('click', () => {
            updateThumbRating(rating, slug)
        })
    })



}

initThumbRatings()