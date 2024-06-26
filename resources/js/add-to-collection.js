/**------------------------------------------------------------
 * add-to-collection.js
 * Ian Kollipara
 *
 * Description: This file contains the JavaScript code to add a
 * a particular content to a user's collection.
 *------------------------------------------------------------**/

export default (contentId) => ({
    contentId,
    toggle(route) {
        fetch(route, {
            method: "POST",
            body: JSON.stringify({ content_id: this.contentId }),
        })
        .then(response => {
            if(response.status === 201) {
                console.log("Added to collection")
            } else if (response.status === 204) {
                console.log("Removed from collection")
            } else {
                console.log(`Error ${response.status} occurred. ${response.statusText} was returned. ${response.url}`)
            }
        })
    }
})
