<?php
$paypal_client_id = 'YOUR_PAYPAL_CLIENT_ID';
$items_file = __DIR__ . '/assets/forsale_items.json';
$items = [];

if (is_file($items_file)) {
    $decoded = json_decode((string) file_get_contents($items_file), true);
    if (is_array($decoded)) {
        $items = array_values(array_filter($decoded, function ($item) {
            return is_array($item) && !empty($item['available']) && empty($item['sample']);
        }));
    }
}

$currency = $items[0]['currency'] ?? 'CAD';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Private items for sale from Jerry Bilous." />
    <title>For Sale | Jerry Bilous</title>
    <link rel="stylesheet" href="styles.css?v=23" />
    <?php if ($paypal_client_id !== 'YOUR_PAYPAL_CLIENT_ID'): ?>
      <script src="https://www.paypal.com/sdk/js?client-id=<?php echo urlencode($paypal_client_id); ?>&currency=<?php echo urlencode($currency); ?>&components=buttons"></script>
    <?php endif; ?>
  </head>
  <body>
    <nav class="nav-bar">
      <div class="nav-container">
        <a href="index.php#hero" class="nav-logo">Back</a>
        <ul class="nav-links">
          <li><a href="index.php#contact">Contact</a></li>
          <li><a href="gallery.php">Gallery</a></li>
        </ul>
      </div>
    </nav>

    <main class="page-shell store-shell">
      <header class="store-header">
        <p class="eyebrow">Private Listings</p>
        <h1>For Sale</h1>
        <p>Personal items listed directly by Jerry. Availability is confirmed before pickup or shipping.</p>
      </header>

      <?php if ($items): ?>
        <section class="store-layout">
          <div class="store-grid" aria-label="Items for sale">
            <?php foreach ($items as $item): ?>
              <?php
                $id = (string) ($item['id'] ?? '');
                $title = (string) ($item['title'] ?? 'Untitled item');
                $description = (string) ($item['description'] ?? '');
                $price = (float) ($item['price'] ?? 0);
                $image = (string) ($item['image'] ?? '');
                $item_currency = (string) ($item['currency'] ?? $currency);
              ?>
              <article
                class="store-item"
                data-id="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>"
                data-title="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>"
                data-price="<?php echo number_format($price, 2, '.', ''); ?>"
                data-currency="<?php echo htmlspecialchars($item_currency, ENT_QUOTES, 'UTF-8'); ?>"
              >
                <?php if ($image): ?>
                  <img src="<?php echo htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>" loading="lazy" />
                <?php endif; ?>
                <div>
                  <h2><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h2>
                  <p><?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?></p>
                  <strong><?php echo htmlspecialchars($item_currency, ENT_QUOTES, 'UTF-8'); ?> $<?php echo number_format($price, 2); ?></strong>
                  <button type="button" class="store-add-button">Add to cart</button>
                </div>
              </article>
            <?php endforeach; ?>
          </div>

          <aside class="store-cart">
            <h2>Cart</h2>
            <div id="cart-items" class="cart-items">
              <p>Your cart is empty.</p>
            </div>
            <div class="cart-total">
              <span>Total</span>
              <strong id="cart-total"><?php echo htmlspecialchars($currency, ENT_QUOTES, 'UTF-8'); ?> $0.00</strong>
            </div>
            <?php if ($paypal_client_id === 'YOUR_PAYPAL_CLIENT_ID'): ?>
              <p class="store-paypal-note">Add your PayPal client ID in <code>forsale.php</code> to activate checkout.</p>
            <?php else: ?>
              <div id="paypal-button-container"></div>
            <?php endif; ?>
            <a class="store-contact-link" href="mailto:mail@jerrybilous.ca?subject=For%20Sale%20Inquiry">Ask before buying</a>
          </aside>
        </section>
      <?php else: ?>
        <section class="store-empty-modal" role="dialog" aria-labelledby="store-empty-title" aria-modal="true">
          <div class="panel store-empty">
            <h2 id="store-empty-title">No items for sale at the moment</h2>
            <p>Please check back later. Private items will appear here when they are available.</p>
            <a class="store-contact-link" href="index.php#hero">Back to home</a>
          </div>
        </section>
      <?php endif; ?>
    </main>

    <script>
      const cart = new Map();
      const cartItems = document.getElementById('cart-items');
      const cartTotal = document.getElementById('cart-total');
      const currency = <?php echo json_encode($currency); ?>;

      function formatMoney(value) {
        return `${currency} $${value.toFixed(2)}`;
      }

      function getCartTotal() {
        return Array.from(cart.values()).reduce((sum, item) => sum + item.price * item.quantity, 0);
      }

      function renderCart() {
        if (!cartItems || !cartTotal) {
          return;
        }

        if (cart.size === 0) {
          cartItems.innerHTML = '<p>Your cart is empty.</p>';
          cartTotal.textContent = formatMoney(0);
          return;
        }

        cartItems.innerHTML = Array.from(cart.values()).map((item) => `
          <div class="cart-line">
            <div>
              <strong>${item.title}</strong>
              <span>${formatMoney(item.price)} x ${item.quantity}</span>
            </div>
            <button type="button" data-remove="${item.id}">Remove</button>
          </div>
        `).join('');
        cartTotal.textContent = formatMoney(getCartTotal());
      }

      document.querySelectorAll('.store-add-button').forEach((button) => {
        button.addEventListener('click', () => {
          const itemEl = button.closest('.store-item');
          const id = itemEl.dataset.id;
          const existing = cart.get(id);

          cart.set(id, {
            id,
            title: itemEl.dataset.title,
            price: Number(itemEl.dataset.price),
            quantity: existing ? existing.quantity + 1 : 1
          });
          renderCart();
        });
      });

      cartItems?.addEventListener('click', (event) => {
        const removeId = event.target.dataset.remove;
        if (removeId) {
          cart.delete(removeId);
          renderCart();
        }
      });

      if (window.paypal) {
        paypal.Buttons({
          createOrder: (data, actions) => {
            const total = getCartTotal();
            if (total <= 0) {
              throw new Error('Cart is empty.');
            }

            return actions.order.create({
              purchase_units: [{
                amount: {
                  currency_code: currency,
                  value: total.toFixed(2)
                }
              }]
            });
          },
          onApprove: (data, actions) => actions.order.capture().then(() => {
            alert('Payment completed. I will follow up to confirm pickup or shipping.');
            cart.clear();
            renderCart();
          })
        }).render('#paypal-button-container');
      }
    </script>
  </body>
</html>
