// Wait until page loads
document.addEventListener("DOMContentLoaded", () => {

    const select = document.getElementById("productOptionSelect");
    const priceDisplay = document.getElementById("priceDisplay");
    const descriptionDisplay = document.getElementById("descriptionDisplay");
    const productImage = document.getElementById("productImage");

    // Safety checks
    if (!select) return;
    if (typeof productOptions === "undefined") return;

    // Preload images 
    const imageCache = {};

    productOptions.forEach(item => {
        const img = new Image();
        img.src = item.Picture;
        imageCache[item.Picture] = img;
    });

    // Update function
    function updateProduct(index) {

        const selectedItem = productOptions[index];
        if (!selectedItem) return;

        // Update price
        priceDisplay.textContent = "$" + selectedItem.Price;

        // Update description
        descriptionDisplay.textContent = selectedItem.Description;

        // Instant image swap (already cached)
        productImage.src = selectedItem.Picture;
    }

    // Dropdown change
    select.addEventListener("change", function () {
        updateProduct(this.value);
    });

});
