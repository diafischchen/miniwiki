<main class="container images">

    <label>
        <div class="searchbar">
                <div class="searchbar-icon">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="searchbar-input">
                <input class="searchbar-input" type="text" name="search" placeholder="Search..." />
            </div>
        </div>
    </label>

    <div class="image-grid">

        <div class="image upload">
            <div class="upload-icon">
                <i class="fa-solid fa-upload"></i>
            </div>
        </div>

    </div>

    <div class="load-more-button">
        <button class="button" id="load-more-button" onclick="loadMoreButtonClick()">load more</button>
    </div>

    
</main>

<script src="<?= JQUERY_CDN ?>" integrity="<?= JQUERY_CDN_INTEGRITY ?>" crossorigin="anonymous"></script>
<script>

const loadMoreButton = document.getElementById('load-more-button')
let loadMoreButtonValid = false

const maxImagesOnLoad = 50
let totalImageLoadIndex = 0

function populateImages(dataArray) {

    let imageString;

    for (let i = 0; totalImageLoadIndex < dataArray.length && i < maxImagesOnLoad; i++) {

        imageString = `
        <div class="image">
            <div class="image-source">
                <img src="<?= ABSURL ?>image?src=${dataArray[totalImageLoadIndex]}" />
            </div>
        </div>
        `;

        document.querySelector('.image-grid').insertAdjacentHTML('beforeend', imageString);
        totalImageLoadIndex++

    }

    if (totalImageLoadIndex == dataArray.length) {
        loadMoreButtonValid = false
    } else {
        loadMoreButtonValid = true
    }

}

function lockLoadMoreButton() {

    loadMoreButtonValid = false
    loadMoreButton.classList.remove('valid')

}

function unlockLoadMoreButton() {

    console.log(loadMoreButtonValid)
    if (loadMoreButtonValid) {
        loadMoreButton.classList.add('valid')
    }

}

function loadImages() {

    lockLoadMoreButton()

    $.ajax({
        url: '<?= ABSURL ?>images/scan',
        method: 'POST',
        success: function(data) {
            populateImages(data);
            unlockLoadMoreButton()
        },
        error: function() {
            // show that remote scan was not successfull
        }
    })

}

function loadMoreButtonClick() {

    if (loadMoreButtonValid) {
        loadImages()
    }

}

loadImages()

</script>
