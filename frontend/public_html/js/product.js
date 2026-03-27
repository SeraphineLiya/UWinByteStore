// Wait until page loads
document.addEventListener("DOMContentLoaded", () => {

    const select = document.getElementById("productOptionSelect");
    const priceDisplay = document.getElementById("priceDisplay");
    const descriptionDisplay = document.getElementById("descriptionDisplay");
    const productImage = document.getElementById("productImage");

    // Safety check
    if (!select || !window.productOptions) return;

    // Cache for preloaded images
    const imageCache = {};

    productOptions.forEach(item => {
        const img = new Image();
        img.src = item.Picture;   // browser downloads once
        imageCache[item.Picture] = img;
    });

    function updateProduct(index) {

        const selectedItem = productOptions[index];
        if (!selectedItem) return;

        // Update text ONLY if changed (avoids repaint cost)
        const newPrice = "$" + selectedItem.Price;
        if (priceDisplay.textContent !== newPrice) {
            priceDisplay.textContent = newPrice;
        }

        if (descriptionDisplay.textContent !== selectedItem.Description) {
            descriptionDisplay.textContent = selectedItem.Description;
        }

        // Instant image swap (already cached)
        if (productImage.src !== selectedItem.Picture) {
            productImage.src = selectedItem.Picture;
        }
    }

    select.addEventListener("change", e => {
        updateProduct(e.target.value);
    });

});