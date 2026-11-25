# Third-Party Licenses

**Product:** NGO Management System
**Document:** Third-Party Open Source Component Licenses

This software includes the following third-party open-source libraries and components.
Each is subject to its own license terms, reproduced or linked below.

---

## 1. Bootstrap

| Property | Value |
|---|---|
| **Library** | Bootstrap |
| **Version** | 5.3.0 |
| **Used for** | Frontend UI framework (grid, components, utilities) |
| **Source** | https://getbootstrap.com |
| **CDN** | `https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/` |
| **License** | MIT License |

### MIT License

```
Copyright (c) 2011-2023 The Bootstrap Authors

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## 2. Font Awesome

| Property | Value |
|---|---|
| **Library** | Font Awesome Free |
| **Version** | 6.4.0 |
| **Used for** | Icons throughout the application |
| **Source** | https://fontawesome.com |
| **CDN** | `https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/` |
| **License** | Mixed (see below) |

### Font Awesome Free License Terms

- **Icons** — [CC BY 4.0 License](https://creativecommons.org/licenses/by/4.0/)
  Attribution is required if icons are used outside the web application context.
- **Fonts** — [SIL OFL 1.1 License](https://scripts.sil.org/OFL)
  Fonts may be embedded and redistributed with software, but may not be sold on their own.
- **Code (CSS, JavaScript)** — [MIT License](https://opensource.org/licenses/MIT)

```
Font Awesome Free License
Copyright 2023 Fonticons, Inc.

The Font Awesome Free download is licensed under a Creative Commons
Attribution 4.0 International License and applies to all icons packaged
as SVG and JS file types, as well as the Font Awesome CSS files.
https://fontawesome.com/license/free
```

---

## 3. dompdf

| Property | Value |
|---|---|
| **Library** | dompdf/dompdf |
| **Version** | ^3.1 |
| **Used for** | HTML to PDF generation (receipts, certificates, offer letters) |
| **Source** | https://github.com/dompdf/dompdf |
| **Installed via** | Composer (`composer.json`) |
| **License** | GNU Lesser General Public License v2.1 (LGPL-2.1) |

### LGPL-2.1 Summary

The GNU LGPL allows this library to be used in commercial software provided:
- The LGPL-licensed library itself (dompdf) remains available under LGPL terms
- If you distribute the library in modified form, the modified library must also be released under LGPL
- You are **not** required to open-source your proprietary application code that uses dompdf

Full license text: https://www.gnu.org/licenses/old-licenses/lgpl-2.1.html

```
dompdf - an HTML to PDF converter
Copyright (C) 2004-2023 The dompdf Authors

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
Lesser General Public License for more details.
```

---

## 4. Razorpay

| Property | Value |
|---|---|
| **Service** | Razorpay Payment Gateway |
| **Used for** | Online donation payment processing |
| **Source** | https://razorpay.com |
| **Integration** | REST API + Razorpay Checkout JS SDK |
| **CDN** | `https://checkout.razorpay.com/v1/checkout.js` |
| **License** | Proprietary / Commercial |

### Notice

Razorpay is a **commercial third-party payment gateway service**. Use of Razorpay requires:

1. A separate, valid Razorpay merchant account
2. Agreement with [Razorpay's Terms of Service](https://razorpay.com/terms/)
3. Razorpay API keys (Key ID + Key Secret) obtained by the end-deployer from their own Razorpay account

The Licensor of this software does **not** provide, sell, or include any Razorpay API credentials. Each deployer is responsible for obtaining their own keys and complying with Razorpay's terms independently.

---

## 5. PDO (PHP Data Objects)

| Property | Value |
|---|---|
| **Extension** | PHP PDO + PDO_MySQL |
| **Used for** | Database abstraction layer |
| **License** | PHP License v3.01 |

This is a standard PHP core extension. Full license: https://www.php.net/license/3_01.txt

---

## Summary Table

| Library | Version | License | Commercial Use Allowed |
|---|---|---|---|
| Bootstrap | 5.3.0 | MIT | ✅ Yes |
| Font Awesome Free (icons) | 6.4.0 | CC BY 4.0 | ✅ Yes (with attribution) |
| Font Awesome Free (fonts) | 6.4.0 | SIL OFL 1.1 | ✅ Yes |
| Font Awesome Free (code) | 6.4.0 | MIT | ✅ Yes |
| dompdf | ^3.1 | LGPL-2.1 | ✅ Yes (see terms) |
| Razorpay Checkout JS | Latest | Proprietary | ✅ Yes (own account required) |
| PHP PDO | Core | PHP License | ✅ Yes |

---

## Compliance Notice

The Licensee (buyer) of the NGO Management System is responsible for:
1. Complying with all third-party licenses listed above
2. Maintaining attribution for CC BY 4.0 licensed components where required
3. Obtaining their own Razorpay merchant account and API credentials
4. Not removing or modifying third-party license notices in the source code

---

*This document was last updated to reflect the third-party components present in the software at time of release.*
