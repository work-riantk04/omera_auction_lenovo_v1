<?php
header('Content-Type: image/svg+xml');
echo '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300">
<rect fill="#1a1a2e" width="400" height="300" rx="8"/>
<rect x="150" y="80" width="100" height="80" fill="none" stroke="#7c3aed" stroke-width="2" rx="4"/>
<circle cx="175" cy="105" r="8" fill="#7c3aed"/>
<polyline points="155,145 180,120 200,135 225,105 245,145" fill="none" stroke="#7c3aed" stroke-width="2"/>
<text x="200" y="200" text-anchor="middle" fill="#666" font-family="Arial" font-size="14">No Image</text>
</svg>';
