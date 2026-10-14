/**
 * Places the server-rendered premium strip below the headline of the given settings category.
 *
 * The settings editor renders its categories into the light DOM; the strip is appended to the category
 * header block (headline + description), so it follows the category when search hides it.
 */
const EDITOR_TAG = 'typo3-backend-settings-editor';
const STRIP_SELECTOR = '.ns-google-sitekit-premium-strip';

export async function insertPremiumStrip(html, categoryKey) {
  await customElements.whenDefined(EDITOR_TAG);
  const editor = document.querySelector(EDITOR_TAG);
  if (!editor) {
    return;
  }
  await editor.updateComplete;

  const place = () => {
    if (editor.querySelector(STRIP_SELECTOR)) {
      return;
    }
    const category = editor.querySelector(`.settings-category[data-key="${CSS.escape(categoryKey)}"]`);
    if (!category) {
      return;
    }
    const template = document.createElement('template');
    template.innerHTML = html;
    category.append(template.content);
  };

  place();
  new MutationObserver(place).observe(editor, { childList: true, subtree: true });
}
