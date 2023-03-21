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
        <button class="button">load more</button>
    </div>

    
</main>

<script src="<?= JQUERY_CDN ?>"></script>
<script>

function populateImages(dataArray) {

    let imageString;

    for (let i = 0; i < dataArray.length; i++) {

        imageString = `
        <div class="image">
            <div class="image-source">
                <img src="<?= ABSURL ?>image?src=${dataArray[i]}" />
            </div>
        </div>
        `;

        document.querySelector('.image-grid').insertAdjacentHTML('beforeend', imageString);

    }

}

$.ajax({
    url: '<?= ABSURL ?>images/scan',
    method: 'POST',
    success: function(data) {
        populateImages(data);
    },
    error: function() {
        // show that remote scan was not successfull
    }
})

</script>
