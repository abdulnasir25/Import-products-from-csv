<p>Dear User,</p>

<p>A new product with SKU {{ !empty($newProduct) ? $newProduct['SKU'] : '' }} has been added, but a product with the same SKU already exists:</p>

<ul>
    <li><strong>Existing Product:</strong> {{ $existingProduct->title }}</li>
</ul>

<p>Please review and take necessary actions.</p>

<p>Thank you.</p>
