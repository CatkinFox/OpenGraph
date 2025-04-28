# BlackFox IT - OpenGraph Image Generator Plugin

Automatically generates OpenGraph images (`og:image`) for your October CMS pages, ensuring attractive previews when shared on social media.

This plugin dynamically creates images by overlaying text (like the page title) onto a background image you provide, using fonts and text placement you configure.

## Basic Usage

1.  **Configure Settings:** Go to `Settings > CMS > OpenGraph Settings` in the backend. Here you can:
    *   Upload your desired background image (recommended 1200x630px).
    *   Upload a TrueType Font file (`.ttf`) for the text.
    *   Choose where the text should appear on the image (e.g., Center Middle, Left Top).
    *   Set the font size in pixels.
2.  **Add Component:** Add the `OpenGraph Image` component to your desired CMS page or layout. In most cases, you'll add it to your main theme layout file so it applies to all pages.
    *   Go to the CMS section, open your layout (e.g., `default.htm`).
    *   Click the `Components` button in the sidebar.
    *   Find `OpenGraph Image` under the `OpenGraph` category and click to add it.
    *   Place the component tag `{% component 'openGraphImage' %}` somewhere within your `<head>` section (it doesn't output visible content directly, only meta tags).

That's it! The plugin will now automatically generate an `og:image` meta tag in the `<head>` of pages using that layout, using the page's title as the default text.

---

## Technical Details & Advanced Configuration

### Requirements

*   **PHP `imagick` Extension:** This plugin relies heavily on the ImageMagick library via its PHP extension (`imagick`). You **must** have this PHP extension installed and enabled on your server for the plugin to function. If the extension is missing, a warning will be displayed on the plugin's settings page.
*   **Write Permissions:** Ensure your web server has write permissions for the `storage/app/media/` directory, as generated images are cached there.

### Component Properties

The `openGraphImage` component has one optional property:

*   **`customTitle` (String):** If you want to use text other than the current page's title (`this.page.title`), you can set this property when adding the component. 
    *   **Example (in Twig):** `{% component 'openGraphImage' customTitle="My Custom Text for This Page" %}`
    *   **Example (in Page/Layout Settings):** Add `customTitle = "My Custom Text"` in the component configuration section of the backend UI.
    If left empty, it defaults to the page title.

### Caching

*   To optimize performance, generated images are cached.
*   An image is generated only once for a unique combination of: background image (and its modification time), font file (and its modification time), text content, text position, and font size.
*   Subsequent requests for the same combination will serve the cached file directly.
*   The cache is automatically invalidated if you change the background image, font file, text content (e.g., page title changes), text position, or font size.
*   Cached images are stored as JPEGs in `storage/app/media/opengraph/generated/`.

### Settings Notes

*   **Background Image Dimensions:** While the plugin recommends 1200x630px, it doesn't strictly enforce this on upload. However, the final generated image *will* be resized to 1200x630px to meet OpenGraph standards. Using source images with significantly different aspect ratios might lead to unexpected cropping or stretching during the final resize.
*   **Font File:** Only `.ttf` (TrueType Font) files are supported. 