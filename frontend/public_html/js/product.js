// Wait until page loads
document.addEventListener("DOMContentLoaded", () => {

    const select = document.getElementById("productOptionSelect");
    const priceDisplay = document.getElementById("priceDisplay");
    const descriptionDisplay = document.getElementById("descriptionDisplay");
    const productImage = document.getElementById("productImage");

    // Safety check
    if (!select || !productOptions) return;

    select.addEventListener("change", function () {

        const selectedIndex = this.value;
        const selectedItem = productOptions[selectedIndex];

        // Update price
        priceDisplay.textContent = "$" + selectedItem.Price;

        // Update description
        descriptionDisplay.textContent = selectedItem.Description;

        // Update image
        productImage.src = selectedItem.Picture;
    });

});