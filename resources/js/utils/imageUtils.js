export function processImages(imageString) {
    return imageString.split(',').map((img) => img.trim());
}