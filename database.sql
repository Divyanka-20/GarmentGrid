-- Creating database

CREATE DATABASE garmentgrid;



-- Using the garments database

USE garmentgrid;



-- Creating table users

CREATE TABLE users (
    name VARCHAR(50) NOT NULL,
    phno VARCHAR(15) NOT NULL UNIQUE,
    email VARCHAR(80) NOT NULL PRIMARY KEY,
    address VARCHAR(200) NOT NULL,
    password VARCHAR(20) NOT NULL
);



-- Creating table for womens

CREATE TABLE womens (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    category VARCHAR(50) NOT NULL
);



-- Creating table for mens

CREATE TABLE mens (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    category VARCHAR(50) NOT NULL
);



-- Creating table for couplewears

CREATE TABLE couplewears (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    category VARCHAR(50) NOT NULL
);



-- Creating table for boyswear

CREATE TABLE boyswear (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    category VARCHAR(50) NOT NULL
);



-- Creating table for girlswear

CREATE TABLE girlswear (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    category VARCHAR(50) NOT NULL
);



-- Creating table for managing shopping cart of users 

CREATE TABLE cart (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(500),
    quantity INT DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- Creating table for coupons

 CREATE TABLE coupons (
    code VARCHAR(50) NOT NULL PRIMARY KEY,
    description TEXT,
    discount_type ENUM('percentage', 'fixed', 'b1g1', 'free_shipping', 'special_price'),
    discount_value DECIMAL(10,2),
    min_order_amount DECIMAL(10,2),
    category VARCHAR(100) 
 );



-- Creating table for user_coupons

CREATE TABLE user_coupons (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100),
    coupon_code VARCHAR(50),
    used_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX (user_name)
);



-- Creating table for orders

CREATE TABLE orders (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NULL,
    total_amount DECIMAL(10,2) NULL,
    discount DECIMAL(10,2) DEFAULT 0.00,
    shipping_fee DECIMAL(10,2) DEFAULT 0.00,
    grand_total DECIMAL(10,2) NULL,
    coupon_code VARCHAR(50) NULL,
    payment_method VARCHAR(50) NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    order_status VARCHAR(20) DEFAULT 'Processing'
);



-- Creating table for order_items

 CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_name VARCHAR(255),
    price DECIMAL(10,2),
    quantity INT,
    FOREIGN KEY (order_id) REFERENCES orders(id)
  );



-- Inserting data in womens table

INSERT INTO womens (id, name, price, description, image, category) VALUES
(1, 'Embroidered Ethnic Saree', 2799.00, 'Elegant ethnic saree with zari work', 'https://i.pinimg.com/originals/a0/0a/f7/a00af7827ef53f9df3d8fb670a3b6410.jpg', 'Ethnic Saree'),
(2, 'Traditional Anarkali Suit', 3199.00, 'Flowy anarkali suit with dupatta', 'https://i.etsystatic.com/37175303/r/il/e85067/4381213377/il_1080xN.4381213377_m0c8.jpg', 'Traditional Suit'),
(3, 'Peplum Indo-Western Dress', 1899.00, 'Fusion style indo-western dress with flared design', 'https://i.pinimg.com/736x/a8/3c/04/a83c04b2934355ea69fbefebe5756281.jpg', 'Indo-western Dress'),
(4, 'Blazer with Pencil Skirt', 1999.00, 'Professional office wear for women', 'https://www.extrapetite.com/wp-content/uploads/2019/06/black-suit-pencil-skirt-e1560302756493.jpg', 'Office Wear'),
(5, 'Striped Jumpsuit', 1499.00, 'Casual western wear perfect for outings', 'https://i.pinimg.com/736x/2a/fc/da/2afcdaa85102a9bc186ac7cf1bf28826--striped-jumpsuit-file.jpg', 'Western Wear'),
(6, 'Floral Embroidered Saree', 2699.00, 'Lightweight saree with delicate floral embroidery', 'https://bigsaree.com/wp-content/uploads/2022/10/vastranand-green-floral-embroidered-organza-saree.jpg', 'Ethnic Saree'),
(7, 'Cotton Silk Saree with Border', 3499.00, 'Elegant cotton silk saree with rich zari border', 'https://assets.myntassets.com/h_200,w_200,c_fill,g_auto/h_1440,q_100,w_1080/v1/assets/images/19253704/2022/8/29/8e501597-202e-4ac3-8789-c22c73f8962a1661776850405-Mitera-Coffee-Brown-Cotton-Silk-Ethnic-Printed-Festive-Saree-1.jpg', 'Ethnic Saree'),
(8, 'Pastel Pink Georgette Saree', 3299.00, 'Soft pastel pink saree with light embroidery work', 'https://www.libaasqueen.com/wp-content/uploads/2022/10/ST-364-3.jpg', 'Ethnic Saree'),
(9, 'Classic Red Banarasi Saree', 3999.00, 'Luxurious Banarasi silk saree in bright red with golden zari', 'https://i.pinimg.com/originals/fa/9e/70/fa9e70a48c6f680e102af5e019dc15ad.jpg', 'Ethnic Saree'),
(10, 'Sequined Party Gown', 3499.00, 'Elegant full-length gown with sequins for parties', 'https://www.thecelebritydresses.com/media/catalog/product/cache/1/image/650x/040ec09b1e35df139433887a97daa66f/f/u/full_length_silver_sequins_v-neck_evening_gown_prom_dress_3_.png', 'Party Wear'),
(11, 'Floral Printed Maxi Dress', 1899.00, 'Casual floral printed maxi dress perfect for summers', 'https://www.chicwish.com/media/catalog/product/cache/789a34736ead3066d85296b038a5aa03/2/4/240622mm.43.jpg', 'Casual Wear'),
(12, 'Sporty Tracksuit', 1599.00, 'Comfortable and stylish tracksuit for workouts', 'https://i8.amplience.net/i/jpl/jd_360853_b?qlt=92&w=750&h=957&v=1', 'Sports Wear'),
(13, 'Embroidered Suede Jacket', 2499.00, 'Lightweight jacket with detailed embroidery for casual outings', 'https://media.atlasformen.com/webmedia/1080by1242/ca/b6/ff/cab6ff51b2292507a902f62f43f4307f.jpg?w=1200', 'Casual Wear'),
(14, 'Silk Office Blouse', 1399.00, 'Elegant silk blouse perfect for office wear', 'https://i.pinimg.com/originals/b0/49/14/b04914fbb960b6160f8febdadb652dae.jpg', 'Office Wear'),
(15, 'Ruffled Party Top', 1199.00, 'Trendy ruffled top for parties and get-togethers', 'https://gloimg.rglcdn.com/rosegal/pdm-product-pic/Clothing/2017/07/19/source-img/20170719181608_98413.jpg', 'Party Wear'),
(16, 'Denim Jeans', 999.00, 'Casual denim jeans ideal for summer', 'https://www.graceandlace.com/cdn/shop/files/PremiumDenimHighWaistedMomJeans-MidWashNonDistressed-4.jpg?v=1691611589', 'Casual Wear'),
(17, 'Ethnic Print Kurti', 1299.00, 'Traditional kurti with ethnic prints', 'https://spegrowmart.com/wp-content/uploads/2022/04/New-Project-2022-04-11T120111.254.jpg', 'Traditional Suit'),
(18, 'Yoga Leggings', 899.00, 'Stretchy and breathable leggings for yoga and workouts', 'https://i5.walmartimages.com/asr/adef85fe-c729-4afe-8493-4fa9b08b3a29.8a677e10d2c9de6937da0a73f3034aa4.jpeg', 'Sports Wear'),
(19, 'Chiffon Palazzo Pants', 1799.00, 'Light and flowy palazzo pants for casual and formal wear', 'https://chapmansclothing.com.au/wp-content/uploads/2023/01/Joseph-Ribkoff-Chiffon-Palazzo-Pant-231754-CC32257-rose.jpg', 'Office Wear'),
(20, 'Lace Evening Dress', 3999.00, 'Beautiful lace dress perfect for formal evening events', 'https://i.pinimg.com/736x/c5/20/dc/c520dc3bdef2922773cd9d39df74eb0a.jpg', 'Party Wear'),
(21, 'Kanjivaram Silk Saree', 4599.00, 'Traditional Kanjivaram silk saree with gold borders', 'https://pictures.kartmax.in/inside/live/1600x1200/quality=6/sites/9s145MyZrWdIAwpU0JYS/product-images/gold_kanjivaram_silk_saree_1721033610as2876129_2.jpg', 'Ethnic Saree'),
(22, 'Chanderi Cotton Saree', 2299.00, 'Handwoven Chanderi cotton saree with block prints', 'https://sutraclothing.in/cdn/shop/files/IMG_6572.webp?v=1718867580&width=1000', 'Ethnic Saree'),
(23, 'Kalamkari Print Saree', 1899.00, 'Ethnic saree with traditional Kalamkari print', 'https://cdn.shopify.com/s/files/1/1760/4649/products/kalamkari-saree-cosmos-peach-kalamkari-saree-silk-saree-online-32253899899073_450x@3x.jpg?v=1651138326', 'Ethnic Saree'),
(24, 'Half and Half Saree', 2499.00, 'Contrasting style half-and-half saree in chiffon', 'https://peachmode.com/cdn/shop/products/green-floral-embroidered-with-foil-printed-chiffon-half-and-half-saree-peachmode-1.jpg?v=1669069416', 'Ethnic Saree'),
(25, 'Organza Silk Saree', 3199.00, 'Sheer and shiny organza silk saree', 'https://static3.azafashions.com/tr:w-575,dpr-2,e-sharpen/uploads/product_gallery/1-0328325001670597441.jpg', 'Ethnic Saree'),
(26, 'Printed Crepe Saree', 1499.00, 'Lightweight crepe saree with digital print', 'https://i.pinimg.com/736x/e1/54/c8/e154c821fe6610741e1dce7fc6d78577.jpg', 'Ethnic Saree'),
(27, 'Brasso Saree', 2699.00, 'Designer brasso fabric with woven motifs', 'https://cdn.shopify.com/s/files/1/0637/4834/1981/products/green-woven-brasso-saree-peachmode-1_e01dc205-0bf2-4882-b48c-6802bb96cdff.jpg?v=1669067946', 'Ethnic Saree'),
(28, 'Handloom Cotton Saree', 1999.00, 'Comfortable and elegant handloom cotton', 'http://www.unnatisilks.com/cdn/shop/files/unm77770-1.jpg?v=1713963631&width=2048', 'Ethnic Saree'),
(29, 'Banarasi Georgette Saree', 3999.00, 'Luxurious Banarasi weave on soft georgette', 'https://www.urbanwomania.com/wp-content/uploads/2022/10/Gray-Banarasi-Satin-Silk-Saree.jpg', 'Ethnic Saree'),
(30, 'Tissue Silk Saree', 2899.00, 'Glossy saree made from rich tissue silk', 'https://www.ekdhaga.in/cdn/shop/files/1_9f15eed4-46a2-4fe0-afd7-99e0042b926d.jpg?v=1688126570&width=940', 'Ethnic Saree'),
(31, 'Gota Patti Saree', 2499.00, 'Traditional Rajasthani saree with gota patti work', 'https://assets.panashindia.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/4/0/4037sr12-112.jpg', 'Ethnic Saree'),
(32, 'Chikankari Anarkali Suit', 2999.00, 'White Anarkali with intricate Lucknowi embroidery', 'https://images.cbazaar.com/images/white-georgette-chikankari-embroidered-stone-work-a-line-anarkali-suit-slscc54195583-u.jpg', 'Traditional Suit'),
(33, 'Punjabi Patiala Suit', 1899.00, 'Vibrant patiala suit with contrast dupatta', 'https://indiaboulevard.in/wp-content/uploads/2022/12/10002-5.jpg', 'Traditional Suit'),
(34, 'Silk Salwar Kameez', 2499.00, 'Rich silk suit perfect for weddings and functions', 'https://5.imimg.com/data5/SELLER/Default/2024/10/455718121/LP/QU/BJ/98768605/172793804839800728-aashirwad-zoha-004-1000x1000.jpeg', 'Traditional Suit'),
(35, 'Printed Cotton Suit Set', 1599.00, 'Lightweight cotton suit with floral patterns', 'https://www.shoplibas.com/cdn/shop/files/33124O_7_0051ba77-7c8c-4fcc-a977-25f41636c83c.webp?v=1739277578&width=1080', 'Traditional Suit'),
(36, 'Georgette Embroidered Suit', 2899.00, 'Soft georgette suit with thread work', 'https://5.imimg.com/data5/ECOM/Default/2024/7/432994062/OF/GT/EU/125286084/rn-image-picker-lib-temp-58a52bfb-3041-47a6-8c0c-b664f22a07ca-500x500.jpg', 'Traditional Suit'),
(37, 'Banarasi Dupatta Suit', 2699.00, 'Banarasi dupatta paired with straight cut suit', 'https://i.pinimg.com/originals/35/f9/73/35f973639fe0fe91a10dc840043205bd.jpg', 'Traditional Suit'),
(38, 'A-Line Kurti Set', 1699.00, 'Flared A-line kurti with palazzo pants', 'https://i.etsystatic.com/22489341/r/il/5202da/3203911478/il_fullxfull.3203911478_pkgx.jpg', 'Traditional Suit'),
(39, 'Floral Muslin Suit Set', 1999.00, 'Soft muslin suit with digital floral print', 'https://riwaazwear.com/cdn/shop/files/STD-156FLORAL_4_1_1.jpg?v=1738561961', 'Traditional Suit'),
(40, 'Bandhani Style Suit', 2299.00, 'Traditional Rajasthani Bandhani printed suit', 'https://cdn.shopify.com/s/files/1/0105/8881/5418/products/onlineshoppingforwomen-2907.jpg?v=1671771951', 'Traditional Suit'),
(41, 'Zari Border Straight Suit', 2399.00, 'Elegant straight-cut suit with zari border', 'https://assets2.andaazfashion.com/media/catalog/product/cache/1/image/500x750/a12781a7f2ccb3d663f7fd01e1bd2e4e/c/h/chinnon-purple-zari-embroidered-straight-suit-lstv132927-1.jpg', 'Traditional Suit'),
(42, 'Cape Style Suit', 2099.00, 'Cape jacket over straight kurta and pants', 'https://static3.azafashions.com/tr:w-450/uploads/product_gallery/1698335222699_1.jpg', 'Traditional Suit'),
(43, 'Mirror Work Kurti Set', 1899.00, 'Kurti with traditional mirror embellishments', 'https://i.pinimg.com/736x/4d/30/2d/4d302d323c965a14d8d0adde83007b4c.jpg', 'Traditional Suit'),
(44, 'Asymmetric Kurti Dress', 1799.00, 'Indo-western flared kurti with side-cut design', 'https://cdn.fynd.com/v2/falling-surf-7c8bb8/fyprod/wrkr/products/pictures/item/free/original/3drUFFGJI-product.jpeg', 'Indo-western Dress'),
(45, 'High-low Hem Dress', 1599.00, 'Fusion style high-low hemline cotton dress', 'https://www.superloudmouth.com/wp-content/uploads/2018/04/indo-western-tops.jpg', 'Indo-western Dress'),
(46, 'Gown Style Kurti', 1899.00, 'Long gown-style kurti with fusion patterns', 'https://i.pinimg.com/originals/46/d6/67/46d667036fe5201d10c32b4f54f2dea5.jpg', 'Indo-western Dress'),
(47, 'Wrap-Around Ethnic Dress', 1999.00, 'Modern wrap-around dress with ethnic motifs', 'http://oneminutesaree.in/cdn/shop/files/OMS-SSKRT-KRDHYA287001-1.jpg?v=1716457166', 'Indo-western Dress'),
(48, 'Cape Indo-Western Set', 2399.00, 'Stylish cape paired with dhoti pants', 'https://images.lifestyleasia.com/wp-content/uploads/sites/7/2022/11/15161429/IMG_2064.jpg', 'Indo-western Dress'),
(49, 'Anarkali Indo-western Fusion', 2299.00, 'Anarkali top with indo-western silhouette', 'https://images.cbazaar.com/images/shamita-shetty-anarkali-gown-in-sea-green-georgette-embroidered-sequins--bgwrscc514410004-u.jpg', 'Indo-western Dress'),
(50, 'Slit Front Kurta Dress', 1799.00, 'Kurta with western-style front slit', 'https://img.faballey.com/images/Product/ITN05218Z/d3.jpg', 'Indo-western Dress'),
(51, 'Frilled Hem Dress', 1499.00, 'Western frills with ethnic patterns', 'https://assets2.andaazfashion.com/media/catalog/product/cache/1/image/500x750/a12781a7f2ccb3d663f7fd01e1bd2e4e/t/e/teal-blue-satin-indo-western-frill-draped-skirt-llcv114030-1.jpg', 'Indo-western Dress'),
(52, 'Pant Style Gown', 2099.00, 'One-piece gown with pants and dupatta', 'https://www.fareenas.com/cdn/shop/files/3_JPEG.jpg?v=1713549934&width=2000', 'Indo-western Dress'),
(53, 'Double Layered Tunic', 1699.00, 'Layered tunic dress with ethnic motifs', 'https://img.faballey.com/images/Product/ITN04611Z/d3.jpg', 'Indo-western Dress'),
(54, 'Front Open Gown Set', 2599.00, 'Stylish front open gown with belt', 'https://cdn.shopify.com/s/files/1/1732/6543/products/FrontOpenGownPakistaniwithWeddingLehengaDress_620x.jpg?v=1669128708', 'Indo-western Dress'),
(55, 'Sharara Indo-western Look', 2399.00, 'Sharara pants paired with short western top', 'https://i.pinimg.com/originals/8a/88/9d/8a889d4534f00adede07cad21569522f.jpg', 'Indo-western Dress'),
(56, 'Formal Shirt & Trousers', 1999.00, 'Crisp shirt with high-waist trousers', 'https://img.faballey.com/Images/Product/BOT00811Z/3.jpg', 'Office Wear'),
(57, 'Pencil Dress', 1899.00, 'Tailored office dress with cap sleeves', 'https://xcdn.next.co.uk/common/items/default/default/publications/g75/shotzoom/24/U85-389s2.jpg', 'Office Wear'),
(58, 'Office Blazer Only', 1599.00, 'Professional single-button blazer', 'https://handcmediastorage.blob.core.windows.net/productimages/JL/JLPZA002-G01-170947-1400px-1820px.jpg', 'Office Wear'),
(59, 'Office Skirt Suit', 2299.00, 'Blazer and skirt co-ord set', 'https://i.pinimg.com/originals/e2/71/73/e271736cc11004f99cbc77bd703340a9.jpg', 'Office Wear'),
(60, 'Pinstripe Shirt', 1299.00, 'White & blue striped shirt for formal setting', 'https://i.pinimg.com/originals/81/a2/3d/81a23d04e2c37841e70730a2e8b24b9c.png', 'Office Wear'),
(61, 'Stretch Fit Pants', 1499.00, 'Stretchable formal pants for all-day wear', 'https://cdna.lystit.com/photos/a02e-2014/01/25/eileen-fisher-plus-black-size-washable-stretch-crepe-slim-ankle-pants-product-1-11685689-0-360096612-normal.jpeg', 'Office Wear'),
(62, 'Collar Blouse', 1199.00, 'Silky blouse with high collar for office', 'https://i.pinimg.com/originals/2a/a6/02/2aa60263c4322fd72bea398b00cc398e.jpg', 'Office Wear'),
(63, 'Blazer Dress', 1899.00, 'One-piece dress styled as a blazer', 'https://cdn-img.prettylittlething.com/8/e/c/3/8ec3f16284746296004a7a967682dcd10ce0b5fc_cnc2988_1.jpg', 'Office Wear'),
(64, 'Solid Shirt with Pleats', 1099.00, 'Formal cotton shirt with sleeve pleats', 'http://cdnb.lystit.com/photos/2012/12/12/vince-camuto-papyrus-pleat-front-blouse-product-2-5816217-061517000.jpeg', 'Office Wear'),
(65, 'Monotone Formal Set', 2199.00, 'Single color shirt + trousers combo', 'https://i.etsystatic.com/26357678/r/il/53c5cc/3928634798/il_794xN.3928634798_kpqe.jpg', 'Office Wear'),
(66, 'Work Kurta Set', 1399.00, 'Indian formal kurta and pant set', 'https://tipsandbeauty.com/wp-content/uploads/2021/04/Designer-Long-Kurta-With-Printed-Palazzo-For-Office.jpg', 'Office Wear'),
(67, 'Business Coat', 1799.00, 'Business Long Coat', 'https://i.etsystatic.com/28561613/r/il/c1f352/3463758821/il_fullxfull.3463758821_he54.jpg', 'Office Wear'),
(68, 'Ruffled Summer Dress', 1499.00, 'Lightweight ruffled dress for casual outings', 'https://i.pinimg.com/736x/2b/ce/3b/2bce3b37a36e7f0cfce3862f5f8264f7.jpg', 'Western Wear'),
(69, 'Off-Shoulder Bodycon Dress', 1999.00, 'Elegant body-hugging dress for parties', 'https://media.boohoo.com/i/boohoo/fzz42904_black_xl/womens-black-off-the-shoulder-split-midi-bodycon-dress/?w=900&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Western Wear'),
(70, 'Denim Dungaree', 1799.00, 'Trendy denim dungaree with adjustable straps', 'https://i.pinimg.com/originals/c6/17/93/c6179347bc2e85291477f17697e29a35.png', 'Western Wear'),
(71, 'Plaid Skirt & Top Set', 1699.00, 'Matching plaid co-ord set for a modern look', 'http://img.ltwebstatic.com/images2_pi/2018/04/24/1524571036700753783.jpg', 'Western Wear'),
(72, 'One Shoulder Jumpsuit', 2299.00, 'Sleek one-shoulder jumpsuit with belt', 'https://media.boohoo.com/i/boohoo/bpp04689_black_xl/female-black-chiffon-extreme-drape-one-shoulder-wide-leg-jumpsuit/?w=900&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Western Wear'),
(73, 'Striped Shirt Dress', 1399.00, 'Button-down shirt dress with stripes', 'https://www.lulus.com/images/product/xlarge/3169240_567232.jpg?w=560', 'Western Wear'),
(74, 'Crop Top & Skirt Combo', 1899.00, 'Matching crop top and skirt set', 'https://i.pinimg.com/originals/cf/5c/fb/cf5cfb6de9a64bc42ae0396c2a7e1cce.jpg', 'Western Wear'),
(75, 'Bell Sleeve Midi Dress', 1499.00, 'Elegant midi dress with bell sleeves', 'https://i.pinimg.com/736x/ae/f5/bc/aef5bc3e9ef77fa22baff816a6dc8f5e.jpg', 'Western Wear'),
(76, 'Front Zip Denim Dress', 1699.00, 'Front zip closure denim dress', 'https://i.pinimg.com/736x/2a/1a/8e/2a1a8eb62d1bd333e7585c2948d2e83c.jpg', 'Western Wear'),
(77, 'Tie-Up Waist Romper', 1799.00, 'Floral print romper with waist tie-up', 'https://i.pinimg.com/originals/1f/b5/58/1fb558fcc269996f107c0f66db3c91d2.jpg', 'Western Wear'),
(78, 'Halter Neck Maxi Dress', 2099.00, 'Maxi length halter neck western dress', 'https://cdn.shopify.com/s/files/1/0519/8561/products/AnabelleHalterNeckMaxiDress-WhiteFloral789181_1000x.jpg?v=1660698763', 'Western Wear'),
(79, 'Pleated A-line Dress', 1499.00, 'A-line silhouette dress with pleats', 'https://i.pinimg.com/736x/ef/72/f1/ef72f181d4a9fdca981726b05b649dc1.jpg', 'Western Wear'),
(80, 'Sequin Mini Dress', 2499.00, 'Shiny mini dress with all-over sequins', 'https://i.pinimg.com/originals/50/88/b8/5088b87dfa6b2a38bf645144d4f40a5e.jpg', 'Party Wear'),
(81, 'Velvet Bodycon Dress', 2899.00, 'Body-hugging velvet dress for evening events', 'https://i.pinimg.com/originals/17/22/19/1722199178c949cddae306510f278c6b.jpg', 'Party Wear'),
(82, 'Ruffle Layered Dress', 1899.00, 'Stylish party dress with layered ruffles', 'https://i.pinimg.com/1200x/ce/54/e6/ce54e62e4044d9773271f3d4e10757c1.jpg', 'Party Wear'),
(83, 'One Shoulder Glitter Dress', 2299.00, 'Sparkly one-shoulder dress for special occasions', 'https://img.davidsbridal.com/is/image/DavidsBridalInc/D24NY23482V1_EMERALD_PROM_PROD1_1314_V2?wid=1080&hei=1620&fit=constrain,1&resmode=sharp2&op_usm=2.5,0.3,4&fmt=webp&qlt=75', 'Party Wear'),
(84, 'Lace Cocktail Dress', 1999.00, 'Elegant lace bodycon cocktail dress', 'https://i.pinimg.com/736x/36/06/e4/3606e4f7d96aac7e7b1ca325b5577f66.jpg', 'Party Wear'),
(85, 'Fit & Flare Satin Gown', 1699.00, 'Satin flare gown with sleeveless top', 'https://www.emmabridals.com/wp-content/uploads/2022/09/EB7748-F3-Plum-scaled.jpg', 'Party Wear'),
(86, 'Backless Party Dress', 2399.00, 'Chic backless dress with shimmering finish', 'https://media.warehousefashion.com/i/warehouse/bpp03656_black_xl', 'Party Wear'),
(87, 'Slit Side Maxi Dress', 2199.00, 'Maxi party dress with high side slit', 'https://5.imimg.com/data5/ECOM/Default/2023/11/358891157/VB/VL/GE/141223455/6173556486-500x500.jpg', 'Party Wear'),
(88, 'Choker Neck Velvet Dress', 2099.00, 'Bodycon velvet dress with choker neckline', 'https://i.pinimg.com/736x/f1/7b/8a/f17b8aa3a361e4c4d7a38323f523a06f.jpg', 'Party Wear'),
(89, 'Metallic Shimmer Dress', 2499.00, 'High-glam metallic shimmer fabric dress', 'https://i.pinimg.com/736x/61/ab/41/61ab4197b077d5c66ffca127faaab353.jpg', 'Party Wear'),
(90, 'Ball Gown for Events', 3299.00, 'Full flare ball gown for grand parties', 'https://www.dressedupgirl.com/wp-content/uploads/2016/01/Elegant-Ball-Gowns.jpg', 'Party Wear'),
(91, 'Strappy Glitter Dress', 1799.00, 'Minimal party dress with strappy glitter style', 'https://slimages.macysassets.com/is/image/MCY/products/8/optimized/26987678_fpx.tif?op_sharpen=1&wid=700&hei=855&fit=fit,1', 'Party Wear'),
(92, 'Printed Cotton Tunic', 999.00, 'Comfortable tunic with floral prints', 'https://www.sisteronline.co.uk/images/sahara-london-sahara-vintage-floral-print-tunic-top-with-pleats-white-multi-p48066-63389_image.jpg', 'Casual Wear'),
(93, 'Solid Color T-Shirt', 699.00, 'Basic cotton tee in solid color', 'https://www.cottonheritage.com/catImg/WAMHIRES/lc1025101_1.jpg', 'Casual Wear'),
(94, 'Denim Shirt Dress', 1499.00, 'Shirt-style denim dress for daily use', 'https://pashandevolve.com.au/cdn/shop/files/Lucinda-Denim-Shirt-Dress-Mid-Blue-Wash-Elm-pashandevolve-2.jpg?v=1720837016', 'Casual Wear'),
(95, 'Loose Fit Hoodie', 1299.00, 'Oversized hoodie for relaxed days', 'https://asda.scene7.com/is/image/Asda/5059196976236?hei=1026&wid=762&qlt=85&fmt=pjpg&resmode=sharp2&op_usm=1.1,0.5,0,0&defaultimage=default_details_George_rd', 'Casual Wear'),
(96, 'Elastic Waist Shorts', 799.00, 'Breathable shorts with side pockets', 'https://i.etsystatic.com/28506783/r/il/ba3e7c/3265045284/il_fullxfull.3265045284_snq4.jpg', 'Casual Wear'),
(97, 'Boho Printed Kaftan', 1299.00, 'Loose casual kaftan for lounging', 'https://i.pinimg.com/originals/10/f3/bc/10f3bc766aae0ad145e403e8383c1f00.jpg', 'Casual Wear'),
(98, 'Basic Leggings', 599.00, 'Stretchable cotton leggings', 'https://www.gap.com/webcontent/0020/365/181/cn20365181.jpg', 'Casual Wear'),
(99, 'Casual Maxi Dress', 1499.00, 'Relaxed-fit maxi dress for daily wear', 'https://i.pinimg.com/736x/3f/c0/4a/3fc04a37862df130b0a16e5ef5074e76.jpg', 'Casual Wear'),
(100, 'Graphic Print Tee', 899.00, 'T-shirt with quirky graphic print', 'https://i.pinimg.com/736x/8e/e7/fe/8ee7fe546f230a4422a9eccc1f7820de.jpg', 'Casual Wear'),
(101, 'Comfy Cotton Pajama', 1199.00, 'Breathable cotton pajama for home wear', 'https://cdn.shopify.com/s/files/1/0279/7079/7651/products/sleepwearsetplussize_1024x1024@2x.jpg?v=1599132578', 'Casual Wear'),
(102, 'Drawstring Skirt', 999.00, 'Skirt with adjustable drawstring', 'https://i.pinimg.com/originals/14/61/cc/1461cc2261f68f7fe7a2ea098313c0af.jpg', 'Casual Wear'),
(103, 'Plain Crew Neck Top', 799.00, 'Simple cotton crew neck top', 'https://media.johnlewiscontent.com/i/JohnLewis/009085593?fmt=auto', 'Casual Wear'),
(104, 'Dry Fit Sports Tee', 999.00, 'Quick dry breathable gym t-shirt', 'https://images-static.nykaa.com/media/catalog/product/tr:h-800,w-800,cm-pad_resize/5/0/504af73AAWTEESM00014902_1.jpg', 'Sports Wear'),
(105, 'Compression Leggings', 1399.00, 'High-compression workout leggings', 'https://www.runningbare.com.au/productimages/medium/1/1835_16614_8465.jpg', 'Sports Wear'),
(106, 'Racerback Tank Top', 899.00, 'Sleeveless racerback tank for gym', 'https://storage.googleapis.com/lulu-fanatics/product/79092/1280/lululemon-lululemon-align-hip-length-racerback-tank-top-roasted-brown-055842-420506.jpg', 'Sports Wear'),
(107, 'Stretch Yoga Pants', 1199.00, 'Flexible yoga pants with high waist', 'https://s.alicdn.com/@sc04/kf/Ha84ccfcf99d447759212f58d6588eca3B.jpg_720x720q50.jpg', 'Sports Wear'),
(108, 'Full-Zip Training Jacket', 1599.00, 'Lightweight jacket for workouts', 'https://assets.myntassets.com/h_200,w_200,c_fill,g_auto/h_1440,q_100,w_1080/v1/assets/images/19477814/2022/8/12/d4a00ab8-aa93-461c-b6a3-7b78ddfe127c1660303711218TrainAllDayFull-ZipTrainingJacketWomen1.jpg', 'Sports Wear'),
(109, 'Workout Co-ord Set', 1999.00, 'Top and legging combo for gym sessions', 'https://www.jiomart.com/images/product/500x630/rvbellt6sh/beau-design-women-workout-co-ord-set-grey-product-images-rvbellt6sh-0-202302062044.jpg', 'Sports Wear'),
(110, 'Breathable Tank & Pants', 1699.00, 'Summer activewear tank + pants', 'https://contents.mediadecathlon.com/p2646846/k$94aab61cec5705aca4657eea095147d7/picture.jpg?format=auto&f=3000x0', 'Sports Wear'),
(111, 'Hooded Sweatshirt', 1599.00, 'Warm-up hoodie for workout sessions', 'https://storage.googleapis.com/lulu-fanatics/product/70847/1280/lululemon-scuba-oversized-half-zip-hoodie-pink-blossom-050898-380565.jpg', 'Sports Wear'),
(112, 'Sleeveless Gym Tee', 799.00, 'Sleeveless breathable gym wear', 'https://image.made-in-china.com/2f0j00PBihyaTluufQ/Women-Antibacterial-Deodrant-Sleeveless-Gym-Workout-Clothes.jpg', 'Sports Wear'),
(113, 'Heeled Sandals', 1299.00, 'Stylish heeled sandals for parties.', 'https://i.pinimg.com/736x/86/a1/2f/86a12f56a3344511d352099c9c95624a.jpg', 'Footwear'),
(114, 'Casual Slippers', 499.00, 'Slip-on slippers for home or quick errands.', 'https://img.kwcdn.com/product/Fancyalgo/VirtualModelMatting/952c1a3f9359dc989d2910fd72b8868f.jpg?imageView2/2/w/800/q/70/format/webp', 'Footwear'),
(115, 'Wedge Sandals', 1399.00, 'Elevated wedge sandals for a classy look.', 'https://i5.walmartimages.com/asr/4b3367be-0fda-4cc2-b8cc-2fc9f4d3f572_1.b74ff85274fd29d9e69888b38f313c02.jpeg', 'Footwear'),
(116, 'Ballerina Flats', 899.00, 'Comfortable and stylish ballerina flats.', 'https://cdnd.lystit.com/photos/cfce-2016/01/26/lanvin-blush-bow-embellished-leather-ballet-flats-pink-product-0-677470547-normal.jpeg', 'Footwear'),
(117, 'Block Heels', 1599.00, 'Trendy block heels for parties.', 'https://greekchichandmades.gr/wp-content/uploads/2022/10/aretiBEIGEsimple03-600x900.jpg', 'Footwear'),
(118, 'Sneakers', 1299.00, 'Everyday wear sneakers for women.', 'https://img.kwcdn.com/product/1dab9a999c/8bbc92f1-e8e7-47f0-9498-6437dc081942_800x800.jpeg?imageView2/2/w/800/q/70/format/webp', 'Footwear'),
(119, 'Gladiator Sandals', 1199.00, 'Chic gladiator sandals for fashionistas.', 'https://i.pinimg.com/736x/52/cd/91/52cd91bfc71481fbd8619bfbb8cc2b89.jpg', 'Footwear'),
(120, 'Ankle Boots', 2199.00, 'Stylish ankle boots for winter.', 'https://i.pinimg.com/originals/d5/a0/6c/d5a06cbf9eb4f7ab357e2e6bd4b9f6b9.jpg', 'Footwear'),
(121, 'Kolhapuri Chappals', 699.00, 'Traditional ethnic chappals.', 'https://static3.azafashions.com/uploads/product_gallery/pom-pom-gold-kolhapuris-0725261001637413588.jpg', 'Footwear'),
(122, 'Kitten Heels', 1499.00, 'Elegant kitten heels for formal wear.', 'https://litb-cgis.rightinthebox.com/images/640x640/202502/bps/product/inc/jjqfed1740567774331.jpg', 'Footwear'),
(123, 'Platform Heels', 1799.00, 'High platform heels for bold style.', 'https://images.asos-media.com/products/public-desire-exclusive-verona-platform-high-heel-sandals-in-rose-gold/203104396-1-rosegold?$n_640w$&wid=513&fit=constrain', 'Footwear'),
(124, 'Home Slippers', 499.00, 'Soft and cozy home slippers.', 'https://media1.popsugar-assets.com/files/thumbor/VME_BcyyFeHvL5o_EFGhxgL9aUY/fit-in/1024x1024/filters:format_auto-!!-:strip_icc-!!-/2018/10/16/765/n/1922564/32522fe95bc61e551c6cd1.87438385_/i/Best-House-Slippers-Women.jpg', 'Footwear'),
(125, 'Leather Shoulder Handbag', 1499.00, 'Elegant brown leather shoulder bag with adjustable strap.', 'https://images.lvrcdn.com/Big77I/T0P/002_793ab8f9-90f3-4a79-9e4e-9618c9b21de3.JPG', 'Accessories'),
(126, 'Shoulder Bag', 1499.00, 'Elegant shoulder bag with metallic chain.', 'https://cdna.lystit.com/photos/556a-2014/01/28/michael-michael-kors-brown-chain-strap-shoulder-bag-product-1-17094920-4-072668539-normal.jpeg', 'Accessories'),
(127, 'Mini Clutch Purse', 599.00, 'Compact clutch purse with sequin finish and button closure.', 'https://anninc.scene7.com/is/image/AN/838755_4974?$fullBpdp$', 'Accessories'),
(128, 'Tassel Fringe Earrings', 249.00, 'Trendy tassel earrings perfect for parties and festive wear.', 'https://i.pinimg.com/originals/d7/a1/c1/d7a1c1e9e90f0bbe1c5ca0b821eec0f0.jpg', 'Accessories'),
(129, 'Statement Ring Set', 299.00, 'Set of 5 rings with assorted designs and adjustable sizes.', 'https://media.centrepointstores.com/i/centrepoint/165045433-165045433-LS23291022_01-2100.jpg?fmt=auto&$quality-standard$&sm=c&$prodimg-m-sqr-pdp-2x$', 'Accessories'),
(130, 'Printed Headband', 199.00, 'Stretchable headband in floral print.', 'https://i.pinimg.com/736x/4c/ac/75/4cac759bcbba0c83d7ec12bed756b267.jpg', 'Accessories'),
(131, 'Elegant Brooch Pin', 279.00, 'Rhinestone-studded brooch for sarees and western outfits.', 'https://assets.myntassets.com/h_200,w_200,c_fill,g_auto/h_1440,q_100,w_1080/v1/assets/images/26900496/2024/1/13/fc10362a-3cec-403c-be24-e0bdb8508efb1705113840270SYGARhinestonesStuddedPeacockCharmBrooch1.jpg', 'Accessories'),
(132, 'Feather Keychain', 149.00, 'Feather keychain with beads and leather cord.', 'https://i.pinimg.com/originals/4a/eb/bf/4aebbfb59ba47af1729f49217d2c25b8.jpg', 'Accessories'),
(133, 'Foldable Tote Bag', 699.00, 'Spacious tote bag made of eco-friendly jute with inner zip.', 'https://image.made-in-china.com/2f0j00UapcHzmJqtru/Customized-Design-Shopper-Jute-Bag-Eco-Friendly-Jute-Gift-Tote-Bag-Reusable-Jute-Burlap-Shopping-Bag.jpg', 'Accessories'),
(134, 'Travel Makeup Organizer', 899.00, 'Portable cosmetic bag with compartments and waterproof lining.', 'https://img.ltwebstatic.com/images3_spmp/2024/11/12/2a/1731399468388e1678a4575ff05dddb0ea623d1e5f_thumbnail_900x.jpg', 'Accessories'),
(135, 'Classic Aviator Sunglasses', 699.00, 'Stylish aviator shades with anti-glare lenses.', 'https://i.pinimg.com/originals/49/7c/9e/497c9ea506a548f8a5860174aa7a198b.jpg', 'Accessories'),
(136, 'Crystal Drop Earrings', 299.00, 'Elegant drop earrings with crystal detailing for festive wear.', 'https://images.urbndata.com/is/image/Anthropologie/91034306_070_b?$a15-pdp-detail-shot$&fit=constrain&qlt=80&wid=640', 'Accessories'),
(137, 'Floral Printed Silk Scarf', 499.00, 'Lightweight silk scarf with multicolor floral design.', 'https://trillionlondon.co.uk/cdn/shop/files/SILK192-FW-PT_5_1800x1800.jpg?v=1710944113', 'Accessories'),
(138, 'Gold-Plated Charm Bracelet', 399.00, 'Trendy charm bracelet with gold finish and adjustable fit.', 'https://media6.ppl-media.com/tr:h-750,w-750,c-at_max,dpr-2/static/img/product/154219/golden-peacock-gold-toned-stainless-steel-gold-plated-charm-bracelet12345678_1_display_1662018825_29bd00d3.jpg', 'Accessories'),
(139, 'Pearl Hair Clip Set', 199.00, 'Set of 3 pearl-studded clips for casual or formal styling.', 'https://www.lulus.com/images/product/xlarge/11202361_2278676.jpg?w=560', 'Accessories'),
(140, 'Slim Faux Leather Belt', 299.00, 'Classic black slim belt with metallic buckle, perfect for dresses.', 'https://oldnavy.gap.com/webcontent/0052/604/385/cn52604385.jpg', 'Accessories'),
(141, 'Rose Gold Analog Watch', 1199.00, 'Elegant rose gold wristwatch with mesh strap and minimal dial.', 'https://cdn.shopify.com/s/files/1/1008/4952/products/AMWW622_2_1800x1800.jpg?v=1668070000', 'Accessories'),
(142, 'Classic Leather Strap Watch', 1399.00, 'Timeless analog watch with genuine leather strap and minimalist dial.', 'http://bagallery.com/cdn/shop/products/6231b6730744e_grande.webp?v=1657014555', 'Accessories'),
(143, 'Matte Liquid Lipstick Set', 799.00, 'Long-lasting matte lipsticks in 5 vibrant shades.', 'https://1.bp.blogspot.com/-z8Nw048FNws/YJvi88wE5nI/AAAAAAAAhKs/hZtPvgiSUpIx51T7YWZNiOaxajKSAyxPQCLcBGAsYHQ/s1674/maybellinesuperstaymatteinklipsticks1.jpg', 'Beauty & Personal Care'),
(144, 'Hydrating Face Serum', 499.00, 'Vitamin C serum for glowing and hydrated skin.', 'https://thesensation.lk/wp-content/uploads/2023/02/817Oich3iBS._SY450_.jpg', 'Beauty & Personal Care'),
(145, 'Nail Polish Combo Pack', 299.00, 'Set of 3 chip-resistant nail polishes in trendy colors.', 'https://m.media-amazon.com/images/I/612x7ZlGhRL._SL1000_.jpg', 'Beauty & Personal Care'),
(146, 'Aloe Vera Moisturizer Gel', 349.00, 'Soothing gel for face and body with pure aloe vera extract.', 'https://i.pinimg.com/originals/42/ba/2b/42ba2bd87ff024f422f5f2a995657931.jpg', 'Beauty & Personal Care'),
(147, 'Makeup Brush Set', 699.00, 'Complete brush kit for flawless makeup application.', 'https://img.ltwebstatic.com/images3_pi/2023/03/02/16777239113cffee5c7c008cd2abe26409fcf8c56c_thumbnail_600x.jpg', 'Beauty & Personal Care'),
(148, 'Charcoal Face Mask', 199.00, 'Detoxifying peel-off mask for clean and refreshed skin.', 'https://beautynearth.com/wp-content/uploads/2022/08/charcoal-face-mask-1-1200x1200.png', 'Beauty & Personal Care'),
(149, 'Rose Water Toner', 249.00, 'Natural toner made with pure rose extract for daily use.', 'https://i.pinimg.com/originals/02/36/34/023634b24c0b97d97dd8ee3613265b65.jpg', 'Beauty & Personal Care'),
(150, 'Herbal Shampoo Bottle', 399.00, 'Sulphate-free herbal shampoo for smooth and healthy hair.', 'https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/38aed870799481.5baf68da1a022.jpg', 'Beauty & Personal Care'),
(151, 'Kajal & Eyeliner Combo', 179.00, 'Smudge-proof kajal and jet-black eyeliner set.', 'https://m.media-amazon.com/images/I/41P9JyMKx0L._SL1080_.jpg', 'Beauty & Personal Care'),
(152, 'Lip Balm Pack', 249.00, 'Pack of 2 fruity lip balms for daily nourishment.', 'https://media.centrepointstores.com/i/centrepoint/165078201-4059729348333-LS18210922_04-2100.jpg?fmt=auto&$quality-standard$&sm=c&$prodimg-m-sqr-pdp-2x$', 'Beauty & Personal Care');



-- Inserting data in mens table

INSERT INTO mens (id, name, price, description, image, category) VALUES
(1, 'Kurta Pajama Set', 2199.00, 'Festive traditional attire with embroidery', 'https://i.etsystatic.com/19394471/r/il/1049b6/3063556877/il_fullxfull.3063556877_bktl.jpg', 'Mens Festive Wear'),
(2, 'Formal Blazer Set', 2599.00, 'Office-ready blazer with trousers', 'https://i.pinimg.com/736x/e0/d4/13/e0d413b8e4ef60d822596bcba8f2ba51.jpg', 'Mens Office Wear'),
(3, 'Casual Checked Shirt', 899.00, 'Stylish shirt for casual outings', 'https://assets.myntassets.com/h_200,w_200,c_fill,g_auto/h_1440,q_100,w_1080/v1/assets/images/28299126/2024/3/16/71fdb189-e475-440a-b108-1edf84d24e971710577375567USMCMenGreyBrownCottonRegularFitCasualCheckedShirt1.jpg', 'Mens Casual Wear'),
(4, 'Denim Jacket', 1899.00, 'Western denim look with trendy appeal', 'https://oldnavy.gap.com/webcontent/0018/590/539/cn18590539.jpg', 'Mens Western Wear'),
(5, 'Printed Party Shirt', 1399.00, 'Bold printed shirt perfect for parties', 'https://assets.myntassets.com/h_200,w_200,c_fill,g_auto/h_1440,q_100,w_1080/v1/assets/images/28644400/2024/9/11/152b25c5-a12c-41ac-9bf4-46280412da621726074644365-Stori-Cotton-Printed-Party-Shirt-2771726074643787-1.jpg', 'Mens Party Wear'),
(6, 'Sports Dry-Fit Set', 1699.00, 'Comfortable breathable dry-fit sportswear', 'https://static.nike.com/a/images/t_default/5709aa61-4952-406f-9b9e-83aa19e05492/dri-fit-woven-training-jacket-j0PLdZ.png', 'Mens Sportswear'),
(7, 'Bandhgala Suit', 3999.00, 'Royal ethnic bandhgala with intricate details', 'https://www.bonsoir.co.in/cdn/shop/products/Cream_Jacquard_Bandhgala_Suit_2048x.jpg?v=1730176196', 'Mens Festive Wear'),
(8, 'Slim Fit Trousers & Shirt', 1799.00, 'Office wear with sleek white shirt combo', 'https://handcmediastorage.blob.core.windows.net/productimages/SE/SEPMV014-G01-132687-800px-1040px.jpg', 'Mens Office Wear'),
(9, 'Polo Neck T-Shirt', 799.00, 'Comfortable cotton polo for everyday use', 'https://images.bestsellerclothing.in/data/selected/6-Aug-2022/149773903_g1.jpg?width=415&height=550&mode=fill&fill=blur&format=auto', 'Mens Casual Wear'),
(10, 'Leather Jacket', 2999.00, 'Rugged and stylish black leather jacket', 'https://cdnc.lystit.com/photos/0008-2013/12/22/john-varvatos-black-usa-denim-style-leather-jacket-product-1-16372802-0-520065417-normal.jpeg', 'Mens Western Wear'),
(11, 'Velvet Dinner Blazer', 3199.00, 'Classy blazer ideal for parties and receptions', 'https://cdn.shopify.com/s/files/1/0935/1466/products/M1A_1e1c3daf-d5f8-4642-872f-003426e52002.jpg?v=1603477582', 'Mens Party Wear'),
(12, 'Track Pants & Tee Set', 1499.00, 'Light & stretchy set for sports or gym', 'https://www.jiomart.com/images/product/500x630/469188358_grey/men-basic-t-shirt-track-pants-set-model-469188358_grey-0-202310100014.jpg', 'Mens Sportswear'),
(13, 'Silk Kurta with Nehru Jacket', 2499.00, 'Elegant silk kurta paired with traditional Nehru jacket', 'https://i.pinimg.com/originals/cd/c7/43/cdc74314b226f158844444bd46aef857.jpg', 'Mens Festive Wear'),
(14, 'Sherwani with Dupatta', 4599.00, 'Luxurious sherwani with intricate embroidery and dupatta', 'https://getethnic.com/wp-content/uploads/2022/04/Blue-Sherwani-1.jpeg', 'Mens Festive Wear'),
(15, 'Chikankari Kurta', 1899.00, 'Light cotton kurta with Chikankari embroidery', 'https://i.etsystatic.com/34650355/r/il/3f2169/4648790728/il_1080xN.4648790728_80u4.jpg', 'Mens Festive Wear'),
(16, 'Pathani Suit', 1699.00, 'Traditional black pathani suit for festive wear', 'https://www.parivarceremony.com/media/catalog/product/cache/62408a38a401bb86dbe3ed2f017b539f/p/1/p1039mw53.jpg', 'Mens Festive Wear'),
(17, 'Velvet Sherwani', 4999.00, 'Rich velvet sherwani with gold embroidery', 'https://images.cbazaar.com/images/bottle-green-velvet-embroidered-indowestern-sherwani-shmac9058-u.jpg', 'Mens Festive Wear'),
(18, 'Mirror Work Kurta', 2199.00, 'Kurta with mirror embellishments', 'https://i.pinimg.com/736x/9f/2d/68/9f2d68c90255d2c53b2dba61c607a5fb.jpg', 'Mens Festive Wear'),
(19, 'Angrakha Style Kurta', 1799.00, 'Asymmetric traditional angrakha kurta', 'https://static3.azafashions.com/uploads/product_gallery/gd00kp147-0594902001650374517.JPG', 'Mens Festive Wear'),
(20, 'Jodhpuri Suit', 3899.00, 'Elegant Indo-western Jodhpuri suit set', 'https://i.pinimg.com/originals/1f/e8/49/1fe849fb8596a1f5f7da551ba57c5286.jpg', 'Mens Festive Wear'),
(21, 'Kurta with Zari Work', 2099.00, 'Elegant kurta with gold zari detailing', 'https://i.pinimg.com/originals/8d/50/67/8d5067a939dbf0402c4a840a3fcface7.jpg', 'Mens Festive Wear'),
(22, 'Festive Dhoti Kurta Set', 1999.00, 'Bright dhoti and kurta with festive colors', 'https://images.indianweddingsaree.com/tr:w-555/product-image/1964688/3.jpg', 'Mens Festive Wear'),
(23, 'Classic White Shirt', 1099.00, 'Crisp white shirt perfect for formal meetings', 'https://handcmediastorage.blob.core.windows.net/productimages/SE/SEPMA020-N01-129156-800px-1040px.jpg', 'Mens Office Wear'),
(24, 'Striped Formal Shirt', 1199.00, 'Blue striped shirt for office professionals', 'https://stylesatlife.com/wp-content/uploads/2018/03/Vertical-Striped-Formal-Shirt.jpg', 'Mens Office Wear'),
(25, 'Grey Formal Trousers', 1499.00, 'Slim-fit grey trousers with crease lines', 'https://infinitymegamall.com/wp-content/uploads/2023/04/39.jpg', 'Mens Office Wear'),
(26, 'Cotton Blazer', 2399.00, 'Soft cotton blazer for semi-formal wear', 'https://cdna.lystit.com/photos/0c46-2014/08/07/he-by-mango-beige-premium-brushed-cotton-blazer-product-1-22302860-0-550636921-normal.jpeg', 'Mens Office Wear'),
(27, 'Light Blue Shirt & Pant Combo', 1899.00, 'Office wear combo with contrast colors', 'http://www.fashionhombre.com/wp-content/uploads/2019/01/Best-Shirt-and-Pant-Combination-For-Men-3-1.jpg', 'Mens Office Wear'),
(28, 'Formal Waistcoat Set', 2799.00, 'Formal 3-piece suit with waistcoat and tie', 'https://www.tom-murphy.ie/wp-content/uploads/2020/04/James_Blk_Suit_03.jpg', 'Mens Office Wear'),
(29, 'Dark Navy Suit', 3899.00, 'Professional navy blue suit for business meetings', 'https://www.suitsexpert.com/wp-content/uploads/navy-suit-white-shirt-color-combination-480x717.jpg', 'Mens Office Wear'),
(30, 'Checks Shirt with Trousers', 1699.00, 'Formal checks shirt paired with black trousers', 'https://assets.myntassets.com/h_200,w_200,c_fill,g_auto/h_1440,q_100,w_1080/v1/assets/images/20272090/2022/10/5/d1ab9e63-e1d5-41a6-b117-a4ac3c4f67af1664951638430AllenSollyMenBlueSlimFitTartanChecksCheckedFormalShirt1.jpg', 'Mens Office Wear'),
(31, 'Pinstripe Suit', 3499.00, 'Classic pinstripe 2-piece suit for daily office', 'https://cdn.shopify.com/s/files/1/0162/2116/files/How_to_wear_blazer_for_men_5.jpg?v=1478897195', 'Mens Office Wear'),
(32, 'Half Sleeve Office Shirt', 899.00, 'Comfortable half sleeve for hot office days', 'https://img1.exportersindia.com/product_images/bc-full/2024/4/4782813/mens-half-sleeve-shirts-1713503446-7384628.jpeg', 'Mens Office Wear'),
(33, 'Henley Neck T-Shirt', 749.00, 'Comfortable casual wear with Henley neck', 'https://media.centrepointstores.com/i/centrepoint/6207760-MHENLEYH1T1116J-SPW2316623_01-2100.jpg?fmt=auto&$quality-standard$&sm=c&$prodimg-m-prt-pdp-2x$', 'Mens Casual Wear'),
(34, 'Casual Linen Shirt', 1299.00, 'Breathable and lightweight linen shirt', 'https://i.etsystatic.com/22844720/r/il/12afdc/2717928756/il_1588xN.2717928756_bu0x.jpg', 'Mens Casual Wear'),
(35, 'Slim Fit Jeans', 1599.00, 'Trendy slim fit jeans with faded effect', 'https://img3.junaroad.com/uiproducts/20133490/std_300_0-1691084794.jpg', 'Mens Casual Wear'),
(36, 'Printed Casual Tee', 699.00, 'Block printed T-shirt with soft fabric', 'https://i.pinimg.com/originals/c1/f7/75/c1f77582678c416159668c84a0540f05.jpg', 'Mens Casual Wear'),
(37, 'Denim Shorts', 799.00, 'Comfortable and durable blue denim shorts', 'https://www.jackshopoutlet.com/wp-content/uploads/2022/11/shorts-jack-jones-mens-chris-original-am-999-denim-shorts-blue-blue-denim-on-sale.jpg', 'Mens Casual Wear'),
(38, 'Cargo Pants', 1299.00, 'Relaxed fit cotton cargo pants with pockets', 'https://wrogn.com/cdn/shop/files/1_1cdfced4-6cff-4d27-b916-75884c60d97e.jpg?v=1710143583&width=1500', 'Mens Casual Wear'),
(39, 'Round Neck T-Shirt', 599.00, 'Everyday solid color T-shirt', 'https://i.pinimg.com/originals/04/13/55/041355a86844455fd549dbad088a2f82.jpg', 'Mens Casual Wear'),
(40, 'Jogger Jeans', 999.00, 'Casual joggers with elastic ankle cuffs', 'https://i.pinimg.com/originals/00/48/ce/0048ce7ac7efd880af408e54382cb68e.jpg', 'Mens Casual Wear'),
(41, 'Polo Tee & Shorts Combo', 1499.00, 'Matching tee and shorts combo for summer', 'https://cdn.shopify.com/s/files/1/0108/7802/files/Polo_shirt_with_shorts_ca064613-78c7-49ef-9edd-d73cf808928e.jpg?v=1554692956', 'Mens Casual Wear'),
(42, 'Relax Fit Cotton Shirt', 1199.00, 'Loose-fit cotton shirt for casual hangouts', 'https://www.westside.com/cdn/shop/files/300997533TAN_1.jpg?v=1732806553&width=1445', 'Mens Casual Wear'),
(43, 'Cowboy Plaid Shirt', 1399.00, 'Bold plaid shirt for western vibes', 'https://www.vintagewesternwear.com/images/products/56336.jpg', 'Mens Western Wear'),
(44, 'Ripped Denim Jeans', 1799.00, 'Distressed blue denim for a rugged look', 'https://i.pinimg.com/originals/aa/85/de/aa85de8109be4dcc485985ae037a21d6.jpg', 'Mens Western Wear'),
(45, 'Suede Jacket', 2799.00, 'Brown suede jacket with western finish', 'https://thepremiumleather.com/wp-content/uploads/2023/04/Grand-Frank-Suede-Jacket-USA-717x1024.webp', 'Mens Western Wear'),
(46, 'Snap Button Shirt', 1199.00, 'Western-style shirt with metal snap buttons', 'https://cdn.shopify.com/s/files/1/0014/0342/0766/products/casual-snap-button-denim-shirt-11270a_3_1400x.jpg?v=1571723868', 'Mens Western Wear'),
(47, 'Bootcut Jeans', 1599.00, 'Western bootcut denim with a relaxed fit', 'https://i.pinimg.com/originals/f1/63/c1/f163c17d9cb6b0f57f215f27c6e3d747.jpg', 'Mens Western Wear'),
(48, 'Corduroy Western Jacket', 2299.00, 'Stylish and warm corduroy jacket', 'https://images.wrangler.com/is/image/Wrangler/MTJCAMR-HERO?$KDP-XXLARGE$', 'Mens Western Wear'),
(49, 'Denim Shirt Jacket', 1899.00, 'Oversized denim shirt doubles as a jacket', 'https://www.outfittrends.com/wp-content/uploads/2017/02/Denim-jacket-with-black-pants.jpeg', 'Mens Western Wear'),
(50, 'Sequin Party Shirt', 1599.00, 'Eye-catching shirt with sequin detailing', 'https://i.pinimg.com/originals/a6/0d/6f/a60d6f78e70ec8209f9d04bbec33932f.jpg', 'Mens Party Wear'),
(51, 'Satin Shirt & Pants Set', 1999.00, 'Glossy satin shirt with matching pants', 'https://i.pinimg.com/736x/ee/04/2d/ee042d063f5075e413526f4f10dca33c.jpg', 'Mens Party Wear'),
(52, 'Black Party Blazer', 2999.00, 'Sharp black blazer with shine finish', 'https://trendia.co/cdn/shop/files/hilo-790.jpg?v=1695616507', 'Mens Party Wear'),
(53, 'Shimmer Slim Shirt', 1299.00, 'Shimmer finish for disco-style parties', 'https://i.pinimg.com/736x/08/e1/ad/08e1ad1bc5326de819cf57ed4fb99314.jpg', 'Mens Party Wear'),
(54, 'Patterned Party Suit', 3299.00, 'Geometric pattern partywear blazer suit', 'https://i.pinimg.com/originals/c3/86/dd/c386dd8aec37cca8e03d3a817e5c8f09.jpg', 'Mens Party Wear'),
(55, 'Metallic Print Shirt', 1399.00, 'Stylish shirt with metallic ink design', 'https://5.imimg.com/data5/SELLER/Default/2022/9/AO/IF/BW/17769549/02-1000x1000.jpg', 'Mens Party Wear'),
(56, 'Velvet Tuxedo Blazer', 3399.00, 'Bold velvet tuxedo for formal events', 'https://i.pinimg.com/originals/0f/d3/18/0fd318963e67b516cf90d02d8c756723.jpg', 'Mens Party Wear'),
(57, 'Party Wear Kurta Set', 2099.00, 'Stylish ethnic kurta with shimmer fabric', 'https://static3.azafashions.com/uploads/product_gallery/dr-m20-azon-01-0706257001603950485.jpg', 'Mens Party Wear'),
(58, 'Black & Gold Blazer', 3499.00, 'Elegant black blazer with gold accents', 'https://www.suitusa.com/images/image59627.jpg', 'Mens Party Wear'),
(59, 'Quick-Dry Running Tee', 899.00, 'Lightweight tee with moisture-wicking fabric', 'https://contents.mediadecathlon.com/p2413694/k$80d75291b59bd2eea7774cda1aa60b85/men-s-seamless-quick-dry-running-t-shirt-turquoise-blue-kiprun-8803450.jpg?f=3620x0&format=auto', 'Mens Sportswear'),
(60, 'Performance Shorts', 799.00, 'Stretchable gym-ready shorts', 'https://reebok.ca/cdn/shop/products/1jgnZFbmI1Ss9KB6cA0OkRwLT1a9z1oZl.jpg?v=1663450342', 'Mens Sportswear'),
(61, 'Training Tank Top', 699.00, 'Sleeveless breathable tank for workouts', 'https://static.thcdn.com/productimg/1600/1600/12388650-2904807817054244.jpg', 'Mens Sportswear'),
(62, 'Joggers with Zipper Pocket', 1499.00, 'Slim-fit joggers for gym or running', 'https://nobero.com/cdn/shop/files/ZipPocketJoggersMen8_c2401fad-734f-46a4-be34-048e7b2fb254.jpg?v=1704180994', 'Mens Sportswear'),
(63, 'Full Sleeve Active Tee', 1099.00, 'Full sleeve sports top with thumb hole', 'https://cdna.lystit.com/1040/1300/n/photos/asos/3876fa14/religion-Black-Long-Sleeve-Muscle-T-shirt-With-Thumb-Hole.jpeg', 'Mens Sportswear'),
(64, 'Compression T-Shirt', 999.00, 'Muscle fit compression tee for training', 'https://contents.mediadecathlon.com/p1746027/k$ffee8fd7b4a23a6454b3b03f0673a60b/sq/T+SHIRT+COMPRESSION+MUSCULATION+BLEU.jpg?f=700x700', 'Mens Sportswear'),
(65, 'Polyester Gym Tracks', 1399.00, 'Soft polyester tracks for high activity', 'https://contents.mediadecathlon.com/p2470502/6047e7e2f70b7ae4b7d76b08608ba31e/p2470502.jpg', 'Mens Sportswear'),
(66, 'Sports Hoodie', 1899.00, 'Hooded sweatshirt for post-workout warmth', 'https://www.sportsdirect.com/images/imgzoom/53/53775702_xxl.jpg', 'Mens Sportswear'),
(67, 'Printed Sports Shorts', 799.00, 'Stylish prints for casual workouts', 'https://i.pinimg.com/originals/98/a0/30/98a030ef76fe3705513acc5cef0f062e.jpg', 'Mens Sportswear'),
(68, 'Athletic Sweatpants', 1299.00, 'Classic sweatpants with elastic waist', 'https://cdn.shopify.com/s/files/1/1008/6090/products/American-Tall-Men-Microsanded-French-Terry-Sweatpant-Marine-Navy-front.jpg?v=1667240614', 'Mens Sportswear'),
(69, 'Casual Sneakers', 1499.00, 'Comfortable sneakers for daily wear.', 'https://i.pinimg.com/originals/db/02/d1/db02d11567886d5cf412ff69fda13282.jpg', 'Footwear'),
(70, 'Formal Leather Shoes', 2599.00, 'Elegant leather shoes perfect for formal occasions.', 'https://i.pinimg.com/736x/2f/d2/47/2fd24739651ddcd1d226be42fc866879.jpg', 'Footwear'),
(71, 'Black Oxford Shoes', 2499.00, 'Classic leather oxfords for formal occasions.', 'https://handcmediastorage.blob.core.windows.net/productimages/OE/OEPLN101-A01-152344-1400px-1820px.jpg', 'Footwear'),
(72, 'Canvas Sneakers', 1199.00, 'Trendy sneakers for casual wear.', 'https://i.pinimg.com/originals/6d/e5/82/6de582c1581b26b57257e14fefb8d4b3.jpg', 'Footwear'),
(73, 'Running Shoes', 1699.00, 'Lightweight running shoes for daily jogs.', 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/793adada-eb18-4f6f-8a0f-b60147b76ab3/alphafly-3-road-racing-shoes-vNzQdQ.png', 'Footwear'),
(74, 'Leather Loafers', 2299.00, 'Slip-on leather loafers for office wear.', 'https://i.pinimg.com/736x/b3/75/66/b3756620abf06ebc354aafcb804bc44e.jpg', 'Footwear'),
(75, 'Chukka Boots', 2799.00, 'Stylish boots for winter wear.', 'https://www.thecoolector.com/wp-content/uploads/2020/08/h25-1.jpg', 'Footwear'),
(76, 'Flip Flops', 399.00, 'Easy-to-wear flip flops for everyday use.', 'https://image1.superdry.com/static/images/optimised/zoom/upload9223368955665509692.jpg', 'Footwear'),
(77, 'Formal Derby Shoes', 2599.00, 'Premium derby shoes for business meetings.', 'https://assets.myntassets.com/h_200,w_200,c_fill,g_auto/h_1440,q_100,w_1080/v1/assets/images/30071365/2024/7/12/ff1c4e15-26e1-42c5-a9f5-39b6e1dc0a471720769140571-IMCOLUS-Men-Formal-Derby-Shoes-5381720769140042-1.jpg', 'Footwear'),
(78, 'Slip-on Sneakers', 1099.00, 'Breathable slip-on sneakers for daily wear.', 'https://img.kwcdn.com/product/1eed511bc8/f6240b25-331f-4a85-9bd6-c56a2553d70c_800x800.jpeg?imageView2/2/w/800/q/70/format/webp', 'Footwear'),
(79, 'Sports Trainers', 1899.00, 'Supportive trainers for intense workouts.', 'https://media.atlasformen.com/webmedia/1080by1242/98/1b/22/981b22b38d2e138adc55710ff57f69d4.jpg', 'Footwear'),
(80, 'Espadrilles', 999.00, 'Soft and comfortable espadrilles.', 'https://i.pinimg.com/736x/64/0e/5d/640e5d1d54bedcb661ca0e114a03480f.jpg', 'Footwear'),
(81, 'Leather Wallet', 699.00, 'Compact brown leather wallet with multiple card slots.', 'https://tanwoodleather.com/wp-content/uploads/2022/12/IMG_3056-1152x1536.jpg', 'Accessories'),
(82, 'Aviator Sunglasses', 999.00, 'Classic aviator sunglasses with UV protection.', 'https://s7d2.scene7.com/is/image/aeo/0508_2014_200_f?$pdp-md-opt$&fmt=jpeg', 'Accessories'),
(83, 'Analog Leather Strap Watch', 1499.00, 'Timeless analog watch with leather strap for everyday wear.', 'https://www.titan.co.in/on/demandware.static/-/Sites-titan-master-catalog/default/dw7cb017e2/images/Titan/Catalog/1825YL04_1.jpg', 'Accessories'),
(84, 'Reversible Belt', 499.00, 'Formal reversible belt with a rotating buckle.', 'https://cdn.edwin-europe.com/media/catalog/product/cache/c0d8e13255319fd43d7de8267e591f40/i/0/i032676_0gl_00-dt-03_1.jpg', 'Accessories'),
(85, 'Baseball Cap', 299.00, 'Adjustable cotton cap with breathable panels.', 'https://media.neimanmarcus.com/f_auto,q_auto/01/nm_4444361_100380_m', 'Accessories'),
(86, 'Canvas Messenger Bag', 899.00, 'Durable canvas bag for work and travel.', 'https://cdn.shopify.com/s/files/1/0003/2725/4068/products/Dakota_Waxed_Canvas_Messenger_Bag_Field_Khaki_With_Chestnut_Brown_2_2000x.jpg?v=1536844940', 'Accessories'),
(87, 'Silk Tie Set', 599.00, 'Formal silk tie with matching pocket square and cufflinks.', 'https://battaglia-beverlyhills.com/cdn/shop/files/TS-LGPTT-014-PAIR.jpg?v=1699252327', 'Accessories'),
(88, 'Sports Watch', 1299.00, 'Water-resistant digital sports watch with stopwatch.', 'https://img.lazcdn.com/g/p/5f94f60d4d40b6676498355a3a5bfb51.jpg_720x720q80.jpg', 'Accessories'),
(89, 'Key Holder Wallet', 499.00, 'Compact wallet with built-in key holder loop.', 'https://ukirkuantan.com.my/wp-content/uploads/2024/01/leather-holder2-scaled.webp', 'Accessories'),
(90, 'Leather Passport Holder', 699.00, 'Travel passport cover with slots for documents.', 'https://media.cntraveler.com/photos/6344bfb9378443a10ebd4a89/master/w_320%2Cc_limit/Passport%2520Holders-2022_Melsbrinna%2520premium%2520leather%2520passport%2520holder.jpg', 'Accessories'),
(91, 'Woolen Scarf', 399.00, 'Warm winter scarf with modern checkered design.', 'https://i.pinimg.com/736x/21/3e/2b/213e2b3fde6cc71255193c5055cd3d95.jpg', 'Accessories'),
(92, 'Minimalist Bracelet', 299.00, 'Black leather band bracelet with metal accent.', 'https://img.kwcdn.com/product/1e19d463eed/34e7e18a-2744-4e70-b9e7-221a32285f64_800x800.jpeg?imageView2/2/w/800/q/70/format/webp', 'Accessories'),
(93, 'Fashion Ring', 349.00, 'Adjustable metallic fashion ring for men.', 'https://images-static.nykaa.com/media/catalog/product/8/f/8f94ebcrfq13_1.jpg', 'Accessories'),
(94, 'Travel Duffel Bag', 1199.00, 'Spacious duffel bag with shoulder strap.', 'https://d326ob4qopjzho.cloudfront.net/cdn/c/SH/240309/th-248RH7I10OI/3.webp', 'Accessories'),
(95, 'Blue Reflective Sunglasses', 899.00, 'Bold reflective sunglasses with blue tint.', 'https://i.pinimg.com/originals/66/ea/47/66ea47b89e652f4aa685475be0ed5a71.jpg', 'Accessories'),
(96, 'Beard Grooming Kit', 899.00, 'Complete grooming kit with oil, comb, scissors & balm.', 'https://www.barterhutt.com/wp-content/uploads/2018/09/BH-8361543.jpg', 'Grooming & Personal Care'),
(97, 'Hair Styling Wax', 349.00, 'Matte finish hair wax for all-day hold.', 'https://vizocosmetics.com/wp-content/uploads/2023/12/Matte-Wax.jpg', 'Grooming & Personal Care'),
(98, 'Charcoal Face Wash', 299.00, 'Deep-cleansing face wash with activated charcoal.', 'https://amiradnan.com/cdn/shop/files/FG-0002411-DeepCleansingFaceWash.jpg?v=1697867984', 'Grooming & Personal Care'),
(99, 'Aftershave Lotion', 449.00, 'Refreshing aftershave lotion with antiseptic properties.', 'https://lathr.com/cdn/shop/files/LATHRAFTERSHAVELOTIONBARBERSHOP_5.jpg?v=1705842555&width=1214', 'Grooming & Personal Care'),
(100, 'Luxury Perfume Spray', 1199.00, 'Long-lasting perfume with musky and woody notes.', 'https://fragranceandbeyond.com/wp-content/uploads/2024/03/GUILTY-STANDARD-1-scaled-1.jpg', 'Grooming & Personal Care'),
(101, 'Beard Oil Bottle', 299.00, 'Enriched with argan oil for soft and healthy beard.', 'https://img.freepik.com/premium-photo/beard-oil-bottle-mockup_1314592-11214.jpg', 'Grooming & Personal Care'),
(102, 'Trimmer Set', 1399.00, 'Rechargeable trimmer with precision blade and USB charging.', 'https://i5.walmartimages.com/seo/Wahl-All-in-One-Rechargeable-Beard-Mustache-Detail-Trimmer-for-Men-Black-05644_8732acf1-33e7-44d6-ab51-f09331ffb8de.024a7bad534acf184d7f91b45dc3ecf8.jpeg', 'Grooming & Personal Care'),
(103, 'Anti-Dandruff Shampoo', 349.00, 'Soothing shampoo for dandruff control and healthy scalp.', 'https://bblunt.com/cdn/shop/files/dandruff_shampoo_6035da1b-f432-41dd-831c-3d4f6948f67b.jpg?v=1734415902&width=3324', 'Grooming & Personal Care'),
(104, 'Men?s Deodorant Stick', 199.00, 'Long-lasting deodorant with cool aqua fragrance.', 'http://aryancare.com/cdn/shop/files/ByondPerfume004-min.jpg?v=1714481309', 'Grooming & Personal Care'),
(105, 'Face Moisturizer Cream', 299.00, 'Lightweight moisturizer for oil-free hydration.', 'https://cdn.shopify.com/s/files/1/0490/6011/8686/products/Haldi-_-Hyaluronic-Acid-Oil-Free-Moisturizer_f7bd0682-e00d-41ff-ac0c-ccc0f24d61d1.jpg?v=1665755134', 'Grooming & Personal Care'),
(106, 'Under Eye Cream', 399.00, 'Reduces puffiness and dark circles for men.', 'https://image.made-in-china.com/2f0j00uvkWshDPYQoz/OEM-Niacinamide-Reduces-Under-Eye-Darkness-Wrinkles-and-Puffiness-Men-Eye-Gel.jpg', 'Grooming & Personal Care'),
(107, 'Sunscreen Lotion SPF 50', 349.00, 'High-protection sunscreen for outdoor activities.', 'https://images.squarespace-cdn.com/content/v1/59399e55b3db2b7352d80836/1665963787936-RC6Y3D4HK5VGSRK316UU/Extreme_Lotion-90mL-1000px-square.jpg', 'Grooming & Personal Care'),
(108, 'Hair Gel for Strong Hold', 199.00, 'Non-sticky gel for all-day style.', 'https://cdn.myshoptet.com/usr/www.slickstyle.cz/user/shop/detail/11486_hairotic-strong-hold-hair-gel-500-ml.jpg?660e8e3e', 'Grooming & Personal Care'),
(109, 'Charcoal Face Scrub', 299.00, 'Exfoliating scrub for deep cleansing.', 'https://smytten-image.gumlet.io/discover_product/1723123551_DTMC0542AB30_1.jpg', 'Grooming & Personal Care');



-- Inserting data in couplewears table

INSERT INTO couplewears (id, name, price, description, image, category) VALUES
(1, 'Matching Festive Outfit Set', 4999.00, 'Perfectly coordinated ethnic outfits for couples', 'https://shaadiwish.com/blog/wp-content/uploads/2020/11/torani.jpg', 'Festive & Traditional'),
(2, 'Casual Matching Tee Set', 1499.00, 'Comfortable and stylish everyday matching tees', 'https://i.pinimg.com/originals/53/99/b4/5399b4087694caf7cb47cc8d025f75a8.jpg', 'Casual Wear'),
(3, 'Anniversary Special Duo', 5999.00, 'Elegant and chic outfits perfect for anniversaries', 'https://i.pinimg.com/originals/63/aa/b1/63aab1c22339087aa01ba4f5c0f2c3b6.jpg', 'Special Occasions'),
(4, 'Vacation Couple Co-ords', 2999.00, 'Lightweight matching sets ideal for travel', 'https://cdn.shopify.com/s/files/1/0804/1709/files/kenny-flowers-matching-couples-outfits-vacation-hawaiian-shirt-summer-maxi-dress-bahamas-2_1024x1024.jpg?v=1687970482', 'Travel & Outdoor'),
(5, 'Trendy Streetwear Duo', 3499.00, 'Urban style matching outfits for the fashionable pair', 'https://i.pinimg.com/736x/39/78/99/3978993156846f504f7ed2b3f7c7bc6e.jpg', 'Creative & Trendy'),
(6, 'Matching Hoodie Set', 1999.00, 'Cozy matching hoodies for couples', 'https://i.pinimg.com/736x/b1/a3/7b/b1a37bef5e8e5a02f5a1a97380720232.jpg', 'Casual Wear'),
(7, 'Ethnic Kurta & Saree Combo', 6999.00, 'Traditional festive kurta and saree set', 'https://www.archittam.com/cdn/shop/files/18_4_comph2.jpg?v=1694511483&width=1080', 'Festive & Traditional'),
(8, 'Beach Couple Co-ords', 2999.00, 'Light and breezy matching beachwear for couples', 'https://noroke.com/cdn/shop/files/Couples_-05_900x.jpg?v=1703072165', 'Travel & Outdoor'),
(9, 'Winter Jacket Duo', 7999.00, 'Warm matching jackets for cold weather', 'https://i.pinimg.com/originals/3e/b2/43/3eb2433b69c7fbe6bef21c6f0737e3c2.jpg', 'Travel & Outdoor'),
(10, 'Custom Print Co-ords', 3999.00, 'Unique personalized matching outfits', 'http://theclothingfactory.in/cdn/shop/collections/The_clothing-23-08-2325795.jpg?v=1698737581', 'Creative & Trendy'),
(11, 'Denim Jacket Set', 4599.00, 'Stylish denim jackets for couples', 'https://i.etsystatic.com/20869831/r/il/6928d9/2775455134/il_fullxfull.2775455134_nq4n.jpg', 'Creative & Trendy'),
(12, 'Festive Lehenga & Sherwani', 8999.00, 'Coordinated traditional lehenga and sherwani', 'https://i.pinimg.com/originals/e7/d5/26/e7d5269dca5866b7e505170cb3230c0b.jpg', 'Festive & Traditional'),
(13, 'Anniversary Casual Set', 2699.00, 'Comfortable casual wear for anniversaries', 'https://5.imimg.com/data5/ECOM/Default/2023/1/DL/SB/WD/52326283/anokherang-salwar-suit-couple-matching-dress-breezy-blue-moroccan-printed-kurti-with-palazzo-and-navy-blue-silk-men-kurta-pajama-couple-matching-dress-38113931231481-500x500.jpg', 'Special Occasions'),
(14, 'Street Style Matching Set', 3199.00, 'Urban streetwear matching set for trendy couples', 'https://i.pinimg.com/originals/83/b2/e8/83b2e8cd6462608a026ae862cd52831b.jpg', 'Creative & Trendy'),
(15, 'Festive Matching Kurtas Set', 4299.00, 'Beautiful matching kurtas for festive occasions', 'https://i.pinimg.com/736x/23/b5/5b/23b55be5c8039e2f685887d50a26a6ac.jpg', 'Festive & Traditional'),
(16, 'Traditional Couple Dress Set', 5999.00, 'Elegant traditional outfits for couples', 'https://i.etsystatic.com/16573877/r/il/93b7b4/4510609234/il_fullxfull.4510609234_4rx2.jpg', 'Festive & Traditional'),
(17, 'Coordinated Ethnic Wear', 7299.00, 'Matching ethnic wear perfect for celebrations', 'https://lovelyweddingmall.com/cache/medium/product/8188/UCe5liqmylMEEUluiGj7gL5bR5TZ7fnwiwl0wgNi.jpeg', 'Festive & Traditional'),
(18, 'Couple Ethnic Festival Set', 7999.00, 'Vibrant festival wear set for couples', 'https://www.raworiya.com/wp-content/uploads/2024/01/0F9A0117-copy.jpg', 'Festive & Traditional'),
(19, 'Matching Saree & Kurta', 6899.00, 'Coordinated saree and kurta set for couples', 'http://5.imimg.com/data5/SELLER/Default/2024/9/454307636/RG/ZT/JR/12678962/matching-men-s-kurta-and-women-s-saree-1000x1000.jpg', 'Festive & Traditional'),
(20, 'Couple Joggers & Tee', 1799.00, 'Casual joggers and tees combo for couples', 'https://i.pinimg.com/736x/34/40/5c/34405cf86f51084fc9c7e21e0c09765e.jpg', 'Casual Wear'),
(21, 'Basic Topwears & Shorts Set', 1299.00, 'Simple matching topwears with shorts', 'https://i.pinimg.com/736x/6b/cb/ee/6bcbeee789496ac3e2b6d30fb35cd783.jpg', 'Casual Wear'),
(22, 'Cozy Sweatshirt Pair', 2499.00, 'Soft and warm sweatshirts for couples', 'https://vivamake.com/wp-content/uploads/2020/06/couple-sweatshirts-with-print-lion-2.jpg', 'Casual Wear'),
(23, 'Relaxed Fit Denim Duo', 2699.00, 'Casual denim jacket and jeans set', 'https://d1flfk77wl2xk4.cloudfront.net/Assets/65/936/XXL_p0162393665.jpg', 'Casual Wear'),
(24, 'Lightweight Couple T-Shirts', 1899.00, 'Breathable casual tshirts for couples', 'https://www.liveenhanced.com/wp-content/uploads/2019/04/couple_tshirts.jpg', 'Casual Wear'),
(25, 'Ceremony Coordinated Set', 6499.00, 'Stylish matching outfits suitable for official ceremonies', 'https://i.pinimg.com/originals/59/c0/da/59c0da2d4da79077a38cb6fea10e3ddd.jpg', 'Special Occasions'),
(26, 'Evening Function Outfit Duo', 7299.00, 'Elegant co-ords for evening social events and functions', 'https://i.pinimg.com/originals/af/4e/33/af4e33803380fa13089627cd99d96e60.jpg', 'Special Occasions'),
(27, 'Cultural Celebration Set', 5899.00, 'Matching outfits ideal for cultural and festive gatherings', 'https://cdn-mediacf.blitzshopdeck.in/NushopCatalogue/tr:f-webp,w-600,fo-auto/yVZsGPbJ_I35W7M3UW7_2023-10-06_1.jpg', 'Special Occasions'),
(28, 'Family Gathering Outfit Combo', 4999.00, 'Neatly styled matching wear for family get-togethers', 'https://www.wholesalecatalog.in/images/product/sub_images/2021/06/Couple-Matching-Kurta-kurti-Yellow-Color-1.jpeg', 'Special Occasions'),
(29, 'Corporate Event Co-ords', 6899.00, 'Smart coordinated outfits suitable for formal events', 'https://cf.shopee.co.id/file/89625d2a011bb2032b4bd7aec3fdaa90', 'Special Occasions'),
(30, 'Occasionwear Blazer Set', 7999.00, 'Classy coordinated blazers and dresses for upscale functions', 'https://i.etsystatic.com/23713226/r/il/cab045/2708419436/il_1140xN.2708419436_s6uh.jpg', 'Special Occasions'),
(31, 'Couple Hiking Set', 4199.00, 'Coordinated hiking wear for outdoor lovers', 'https://nobero.com/cdn/shop/products/10_c08d1716-e7e2-4cf6-aec0-ec138dcf3f14.jpg?v=1675432624', 'Travel & Outdoor'),
(32, 'Casual Travel Set', 3199.00, 'Easy-to-wear travel outfits for couples', 'https://i.pinimg.com/originals/6a/d1/d0/6ad1d0f3e850495abd7f3009df86cc67.jpg', 'Travel & Outdoor'),
(33, 'Desert Mirage Duo', 4899.00, 'Breezy and breathable matching cotton sets ideal for desert tours and sunlit explorations', 'http://ak7.picdn.net/shutterstock/videos/2146277/thumb/9.jpg', 'Travel & Outdoor'),
(34, 'Urban Getaway Duo', 4599.00, 'Modern and minimal, this neutral-toned travelwear is made for metro exploration in style', 'https://i.etsystatic.com/19961590/r/il/946cd0/4097786621/il_fullxfull.4097786621_tmm9.jpg', 'Travel & Outdoor'),
(35, 'Tropic Tides Set', 3199.00, 'Matching tropical co-ords for beach sunsets, island strolls, and summer vibes', 'https://images.nexusapp.co/assets/9f/c7/67/346921487.jpg', 'Travel & Outdoor'),
(36, 'Urban Denim Duo', 4299.00, 'Trendy denim jackets and jeans', 'https://i.pinimg.com/736x/d1/70/27/d170270a37f691be3e4be33f994673ae.jpg', 'Creative & Trendy'),
(37, 'Color Block Duo', 3699.00, 'Bold color block matching sets', 'https://i.pinimg.com/originals/8b/59/7a/8b597a61d72bca43247e973878eb3d56.jpg', 'Creative & Trendy'),
(38, 'Minimalist Match Set', 2799.00, 'Clean, simple, and stylish matching outfits', 'https://i.pinimg.com/originals/66/cb/ce/66cbce772b585389d218697403827707.jpg', 'Creative & Trendy');



-- Inserting data in boyswear table

INSERT INTO boyswear (id, name, price, description, image, category) VALUES
(1, 'Denim Shirt and Jeans', 1299.00, 'Trendy wear for boys', 'https://i.pinimg.com/originals/b3/fb/f5/b3fbf58de2c7e63f8066e3cd42d51270.jpg', 'Casual Boys Wear'),
(2, 'Graphic T-Shirt with Shorts', 899.00, 'Cotton graphic tee with cool shorts for a relaxed look', 'https://slimages.macysassets.com/is/image/MCY/products/1/optimized/27374051_fpx.tif', 'Casual Boys Wear'),
(3, 'Kurta with Nehru Jacket', 1599.00, 'Elegant kurta set paired with printed Nehru jacket', 'https://static3.azafashions.com/uploads/product_gallery/1717002900176_1.JPG', 'Festive Boys Wear'),
(4, 'Sherwani Set for Boys', 2199.00, 'Traditional sherwani with golden embroidery perfect for occasions', 'https://i.pinimg.com/736x/a4/b5/49/a4b549c058912f488a19d21cca52435b.jpg', 'Festive Boys Wear'),
(5, 'Sleeveless Tank with Shorts', 749.00, 'Light cotton summer outfit with vibrant prints', 'https://i5.walmartimages.com/seo/Boys-Tank-Top-Shirts-Cooling-Quick-Dry-Activewear-Sleeveless-Shirt-with-Wide-Shoulder-Straps-Stained-Glass-Dragon-6T_5e727a75-83aa-4898-8bde-3a1f9534225e.47242019c5768cdbbb5835851f400288.jpeg', 'Boys Summer Wear'),
(6, 'Striped Polo with Capris', 999.00, 'Breathable fabric perfect for sunny days', 'https://i.pinimg.com/originals/88/bc/37/88bc3726f1f7fbc717ec751ba4b6c93b.jpg', 'Boys Summer Wear'),
(7, 'Blazer with Jeans Combo', 1899.00, 'Smart western outfit for parties and functions', 'https://i.pinimg.com/originals/59/14/e3/5914e3f0fda307b84ff02d3e0dccad8b.jpg', 'Boys Western Wear'),
(8, 'Hoodie with Joggers Set', 1199.00, 'Trendy and comfortable winter western outfit', 'https://i.pinimg.com/originals/e0/a6/7e/e0a67ee7c50a2e1d7a01ab1552b00465.jpg', 'Boys Western Wear'),
(9, 'Checked Shirt & Khakis', 1199.00, 'Stylish checked shirt with comfortable khaki pants', 'https://i.pinimg.com/originals/58/d0/8f/58d08f35fc3be8b91c5cfdd078e9710a.jpg', 'Casual Boys Wear'),
(10, 'Colorblock T-Shirt', 899.00, 'Trendy colorblock tee perfect for daily outings', 'https://i.pinimg.com/originals/d1/50/89/d150890fda0247d737306624dfd1e1f8.png', 'Casual Boys Wear'),
(11, 'Printed Sweatshirt', 1299.00, 'Cotton sweatshirt with creative graphics', 'https://img-lcwaikiki.mncdn.com/mnresize/1020/1360/pim/productimages/20232/6559709/v1/l_20232-w38314z1-lsp-93-24_5.jpg', 'Casual Boys Wear'),
(12, 'Cool Hoodie', 899.00, 'Trendy hoodie', 'https://tse1.mm.bing.net/th?id=OIP.X4TfV-sC0pd5vBzicWL81AHaLH&pid=Api&P=0&h=220', 'Casual Boys Wear'),
(13, 'Tee & Jogger Set', 999.00, 'Comfy joggers with tee', 'https://i.pinimg.com/originals/af/d9/28/afd9282dee1cb22a67dfd2e9a9b3c662.jpg', 'Casual Boys Wear'),
(14, 'Basic Tee & Sweatpants Combo', 849.00, 'Everyday basic cotton tee with elastic waist pants', 'https://i.pinimg.com/originals/f4/d3/10/f4d3104330aaa7727d634bb8b41e9988.jpg', 'Casual Boys Wear'),
(15, 'Shirt with Cargo Shorts', 1099.00, 'Classic shirt with comfy cargo shorts', 'https://www.gap.com/webcontent/0053/563/652/cn53563652.jpg', 'Casual Boys Wear'),
(16, 'T-Shirt with Denim Shorts', 899.00, 'Tee paired with trendy denim shorts', 'https://i.pinimg.com/originals/60/43/cd/6043cded99ecae128c171811ca7661c6.jpg', 'Casual Boys Wear'),
(17, 'Printed Cotton Co-ord Set', 999.00, 'Soft cotton co-ord set with vibrant prints', 'https://img.ltwebstatic.com/images3_pi/2023/01/09/1673229762d27221f93b6f412268877a253828580f_thumbnail_600x.jpg', 'Casual Boys Wear'),
(18, 'Bomber Jacket & Tee', 1399.00, 'Jacket and tee combo perfect for casual outings', 'https://oldnavy.gap.com/webcontent/0056/345/610/cn56345610.jpg', 'Casual Boys Wear'),
(19, 'Pathani Suit Set', 1799.00, 'Elegant pathani suit for traditional occasions', 'https://i.pinimg.com/736x/63/65/b6/6365b61ccbd2eb5a3d063940204aadc9.jpg', 'Festive Boys Wear'),
(20, 'Kurta Pyjama', 1999.00, 'Royal kurta with churidar for festive events', 'https://images.cbazaar.com/images/multi-colored-blended-cotton-printed-kids-boys-kurta-pyjama-kdbmss6254-u.jpg', 'Festive Boys Wear'),
(21, 'Indo-Western Set', 2499.00, 'Modern indo-western outfit with asymmetric design', 'https://i.pinimg.com/originals/81/f9/cf/81f9cf5199e70e502de07c6ef3bc660d.jpg', 'Festive Boys Wear'),
(22, 'Embroidered Dhoti Kurta', 1799.00, 'Traditional dhoti style set with elegant thread work', 'https://images.cbazaar.com/images/aqua-blue-embroidered-dupion-silk-kids-dhoti-style-kurta-pyjama-kdbknfc001aq-u.jpg', 'Festive Boys Wear'),
(23, 'Bandhgala Suit for Boys', 2599.00, 'Classy bandhgala outfit ideal for weddings', 'https://i.pinimg.com/736x/43/59/00/435900cc6603199c17cf72fdecb8480f.jpg', 'Festive Boys Wear'),
(24, 'Angrakha Style Kurta Set', 1899.00, 'Traditional angrakha pattern with churidar', 'https://manyavar.scene7.com/is/image/manyavar/CDJS001-333_3_16-08-2023-00-28?wid=1244', 'Festive Boys Wear'),
(25, 'Brocade Kurta Pajama', 1899.00, 'Shiny brocade kurta pajama set for weddings', 'https://www.sareez.com/uploads/sareez/products/brown-dupion-silk-brocade-festival-traditional-kurta-dhoti-boys-wear-310488_m.jpg', 'Festive Boys Wear'),
(26, 'Royal Sherwani Set', 2499.00, 'Heavy embroidered sherwani for grand occasions', 'https://medias.utsavfashion.com/media/catalog/product/cache/1/small_image/295x/040ec09b1e35df139433887a97daa66f/w/o/woven-art-silk-jacquard-jacket-style-sherwani-in-cream-and-off-white-v1-ush78.jpg', 'Festive Boys Wear'),
(27, 'Traditional Dhoti Kurta', 1399.00, 'Ethnic dhoti with printed kurta for boys', 'https://i.etsystatic.com/46242245/r/il/63ee18/5681175179/il_794xN.5681175179_j2n0.jpg', 'Festive Boys Wear'),
(28, 'Beachwear Printed Set', 799.00, 'Bright beach-style set for summer vacations', 'https://i.pinimg.com/originals/59/07/57/590757e706e6e50ae3094526bdfdbd31.jpg', 'Boys Summer Wear'),
(29, 'Tropical Shirt & Shorts', 899.00, 'Tropical print shirt with casual shorts', 'https://i.pinimg.com/originals/c2/79/08/c279084557e3c7d7ad68696698c9e001.jpg', 'Boys Summer Wear'),
(30, 'Cotton Half-Sleeve Co-ord', 849.00, 'Half-sleeve shirt and shorts combo', 'https://i.pinimg.com/originals/4f/98/e2/4f98e24d71701f78720e54faeeb81643.jpg', 'Boys Summer Wear'),
(31, 'Printed Tank & Shorts Set', 799.00, 'Easy-breezy co-ord for park or play', 'https://i.pinimg.com/originals/52/26/7b/52267b5819abaf05c5ab195732dae0a9.png', 'Boys Summer Wear'),
(32, 'Cotton Co-ord with Cap', 949.00, 'Comfortable cotton summer set with cap', 'https://prod-img.thesouledstore.com/public/theSoul/uploads/catalog/product/Peppa%20Space_42024_04_06-22-34-29.jpg?format=webp&w=480&dpr=1.0', 'Boys Summer Wear'),
(33, 'Loose Fit Lounge Set', 749.00, 'Relax-fit shirt and pant combo', 'https://i.pinimg.com/originals/f8/24/ac/f824ace74015d7d1daffa8a650187476.jpg', 'Boys Summer Wear'),
(34, 'Pineapple Print Shirt & Shorts', 999.00, 'Fun pineapple-printed summer set', 'https://i.pinimg.com/originals/5c/cc/90/5ccc904550031ad9264986f952030e62.jpg', 'Boys Summer Wear'),
(35, 'Sleeveless Cotton Vest Set', 799.00, 'Cool cotton vests with matching shorts', 'https://i.pinimg.com/originals/38/08/18/380818b96d65762243dab0ac77279d72.jpg', 'Boys Summer Wear'),
(36, 'Co-ord Set', 899.00, 'Lightweight outfit with graphics', 'https://i.pinimg.com/564x/31/fc/19/31fc19a92f9ff1b0b4456506fada91f0.jpg', 'Boys Summer Wear'),
(37, 'Sunset Yellow Polo Set', 999.00, 'Bright yellow polo and soft shorts for summer', 'https://i.pinimg.com/originals/d3/88/18/d38818f96d0df953d14e82789966814c.jpg', 'Boys Summer Wear'),
(38, 'Leather Jacket & Jeans Combo', 1699.00, 'Cool leather jacket paired with jeans', 'https://i.pinimg.com/originals/a6/f4/2f/a6f42f77ca7b072522882e5f274d9d30.jpg', 'Boys Western Wear'),
(39, 'Tuxedo Style Party Suit', 2099.00, 'Stylish western tuxedo for formal parties', 'https://shop.r10s.jp/goldbunnykikaku/cabinet/03029871/imgrc0071616733.jpg', 'Boys Western Wear'),
(40, 'Formal Vest & Pant Set', 1799.00, 'Vest with shirt and pants for formal wear', 'https://i.pinimg.com/originals/49/88/86/4988867cb8c033b41053f6c72b7b6b2f.jpg', 'Boys Western Wear'),
(41, 'Check Blazer & Tie Outfit', 1999.00, 'Elegant checkered blazer and tie set', 'https://cdn.childrensalon.com/media/catalog/product/cache/0/image/1000x1000/9df78eab33525d08d6e5fb8d27136e95/p/a/patachou-boys-grey-check-blazer-569972-598a93df052490c6a5d95a57367f5504d89177a7-outfit.jpg', 'Boys Western Wear'),
(42, 'Double Breasted Suit', 2299.00, 'Modern double-breasted suit for boys', 'https://m.media-amazon.com/images/I/71-6-eGBNwL._AC_UY1000_.jpg', 'Boys Western Wear'),
(43, 'Formal Vest and Shirt Set', 1699.00, 'Classy formal look with vest and bowtie', 'https://sa.redtagfashion.com/cdn/shop/files/128232003_1-Beige_20Vest_20And_20Long_20Sleeve_20Shirt_20Set.jpg?v=1708673435', 'Boys Western Wear'),
(44, 'Shirt with Suspenders', 1199.00, 'Western party outfit shirt', 'https://i.pinimg.com/474x/07/b3/cd/07b3cd650f1b863ed0f390ace799f92a.jpg', 'Boys Western Wear'),
(45, 'Denim Jacket', 1499.00, 'Trendy western jacket for outing', 'https://oldnavy.gap.com/webcontent/0053/483/092/cn53483092.jpg', 'Boys Western Wear'),
(46, 'Striped Blazer Look', 1799.00, 'Stylish striped blazer for young boys', 'https://i.pinimg.com/originals/62/5d/90/625d9028b4c90899520c0f7b22c40337.jpg', 'Western Wear'),
(47, 'Boys Sports Sandals', 799.00, 'Durable sandals for active boys.', 'https://img.kwcdn.com/product/open/2023-03-22/1679454125790-6893aa314b0042e4a067a789cbf64ef9-goods.jpeg?imageView2/2/w/800/q/70/format/webp', 'Footwear'),
(48, 'Casual Flip Flops', 399.00, 'Comfy flip flops for boys.', 'https://cdn.shopify.com/s/files/1/2049/2073/files/Tammy-Men_s-Casual-Flip-Flop-uss-seller-shoes-5_1024x1024.png?v=1658289515', 'Footwear'),
(49, 'Velcro Sports Shoes', 899.00, 'Easy-to-wear velcro shoes for active boys.', 'https://5.imimg.com/data5/SELLER/Default/2024/3/396809216/RW/MN/DQ/34875781/1-500x500.jpg', 'Footwear'),
(50, 'Casual Sandals', 699.00, 'Everyday sandals for boys.', 'https://i.pinimg.com/originals/ab/ed/71/abed710833f6d4c7e6f20ce3683f3d79.jpg', 'Footwear'),
(51, 'Slip-on Loafers', 799.00, 'Trendy loafers for kids.', 'https://cdn.shoplightspeed.com/shops/621888/files/52759663/1600x2048x1/mia-kids-lil-carson-loafer-in-tan.jpg', 'Footwear'),
(52, 'Printed Flip Flops', 349.00, 'Cartoon printed flip flops.', 'https://img-lcwaikiki.mncdn.com/mnresize/1020/1360/pim/productimages/20221/5820350/l_20221-s2hd40z4-huc_a2.jpg', 'Footwear'),
(53, 'Rain Boots', 999.00, 'Waterproof rain boots for the monsoon.', 'https://img.kwcdn.com/product/Fancyalgo/VirtualModelMatting/b08db5ddd90c43b1d5d7a23f557c5888.jpg', 'Footwear'),
(54, 'Sneakers', 1099.00, 'Cool sneakers for school.', 'https://media-uk.landmarkshops.in/cdn-cgi/image/h=831,w=615,q=85,fit=cover/max-new/1000013123800-Grey-GREY-1000013123800_06-2100.jpg', 'Footwear'),
(55, 'LED Shoes', 1299.00, 'Shoes with lights that kids love.', 'https://cdn.sparkfun.com/assets/learn_tutorials/6/7/9/IMG_7062sm.jpg', 'Footwear'),
(56, 'Canvas Shoes', 849.00, 'Durable canvas shoes.', 'https://images.journeys.com/images/products/1_702497_FS_THERO.JPG', 'Footwear'),
(57, 'Ankle Boots', 1199.00, 'Cute boots for chilly weather.', 'https://i.pinimg.com/736x/3c/e2/dd/3ce2dd9f4a3f5d835cff9e61379bb75d.jpg', 'Footwear'),
(58, 'Home Slippers', 499.00, 'Comfy slippers for indoor use.', 'https://i.ezbuy.sg/FohVIakwn-pQuHBGHH9QTKfel_Ex', 'Footwear'),
(59, 'Baseball Cap', 299.00, 'Adjustable cotton baseball cap with breathable fabric.', 'https://tse4.mm.bing.net/th/id/OIP.Ww3vvMGcdNIR0xhcKvGcDgHaJ4?pid=Api&P=0&h=220', 'Accessories'),
(60, 'Kids Sunglasses', 399.00, 'UV protection sunglasses designed for kids.', 'https://images.nexusapp.co/assets/84/1d/03/392562628.jpg', 'Accessories'),
(61, 'Colorful Backpack', 799.00, 'Lightweight backpack with multiple compartments.', 'https://thumbs.dreamstime.com/b/colorful-school-backpack-d-cartoon-style-illustration-isolated-white-background-versatile-eye-catching-element-286760250.jpg', 'Accessories'),
(62, 'Cartoon Wristwatch', 599.00, 'Fun digital wristwatch featuring popular cartoon characters.', 'https://i5.walmartimages.com/seo/Sonic-Game-Character-Wristwatch_ae096dee-fd02-499b-b447-4402d73f596e.739fae72db977f00027c03065ffa32c8.jpeg', 'Accessories'),
(63, 'Kids Belt', 249.00, 'Adjustable synthetic leather belt with buckle.', 'https://tbi.cdn.pacerace.de/media/images/popup/TB5851_Pw1-00003.jpg', 'Accessories'),
(64, 'Rain Poncho', 399.00, 'Waterproof rain poncho with hood for kids.', 'https://i5.walmartimages.com/seo/TELOLY-Poncho-Reflective-Children-s-Drawstring-Ponchos-Flexible-Waterproof-Rain-Jacket-Adjustable-Hood-Comfortable-Kids-Poncho-All-Seasons_431efad3-9686-4497-a394-4b9dd7920329.88991da43f142a9aedafe5dfb91617af.jpeg', 'Accessories'),
(65, 'Water Bottle', 299.00, 'BPA-free water bottle with fun designs.', 'https://i.pinimg.com/736x/9e/8a/fd/9e8afd1479e8046589b1f1536834cb71.jpg', 'Accessories'),
(66, 'Kids Gloves', 199.00, 'Warm knit gloves perfect for winter.', 'https://handarmorgloves.com/wp-content/uploads/2021/08/2204OR.jpg', 'Accessories'),
(67, 'School Lunch Box', 349.00, 'Leak-proof lunch box with compartments.', 'https://5.imimg.com/data5/SELLER/Default/2024/6/431148875/MY/BL/MU/57888296/ibni-leak-proof-3-compartment-lunch-tiffin-box-freezer-safe-stainless-steel-1000x1000.jpg', 'Accessories');



-- Inserting data in girlswear table

INSERT INTO girlswear (id, name, price, description, image, category) VALUES
(1, 'Floral Frock', 1199.00, 'Colorful floral frock for girls', 'https://i.pinimg.com/originals/df/aa/81/dfaa81a536e11ed86251c118b36e7edb.jpg', 'Casual Girls Wear'),
(2, 'Cartoon Printed Cotton Dress', 899.00, 'Soft cartoon-themed cotton dress for everyday fun wear', 'https://www.labibabymall.com/cdn/shop/articles/Sacde7cf2f3c84feaac80ae837bd87136b_1024x1024.jpg?v=1723096403', 'Casual Girls Wear'),
(3, 'Lehenga Choli Set', 1799.00, 'Traditional lehenga with embroidered choli and dupatta for special events', 'https://static3.azafashions.com/uploads/product_gallery/1640292-0749625001655902626.jpg', 'Festive Girls Wear'),
(4, 'Anarkali Gown for Girls', 2099.00, 'Elegant Anarkali-style gown with golden thread work', 'https://i.pinimg.com/originals/95/f1/a7/95f1a74dedf626b04bb374768caf5e16.jpg', 'Festive Girls Wear'),
(5, 'Sleeveless Summer Frock', 699.00, 'Breathable sleeveless frock with bright summer prints', 'https://i.pinimg.com/originals/01/10/ac/0110ac38a3a2229a3cba02ddff2a4257.jpg', 'Girls Summer Wear'),
(6, 'Cotton Romper Set', 649.00, 'Soft cotton rompers ideal for hot summer days', 'https://i.pinimg.com/736x/8d/d0/53/8dd053e832e6f25615037fd51e63e964.jpg', 'Girls Summer Wear'),
(7, 'Denim Skirt with T-Shirt', 1099.00, 'Trendy denim skirt paired with a funky printed tee', 'https://i.pinimg.com/736x/b9/36/4d/b9364d8a3048bf210b602c2278d0fe48.jpg', 'Girls Western Wear'),
(8, 'Stylish Jumpsuit for Girls', 1399.00, 'One-piece sleeveless jumpsuit with belt and side pockets', 'https://i.pinimg.com/originals/23/08/f2/2308f25d1117b2b61040ffde3fea6646.jpg', 'Girls Western Wear'),
(9, 'Printed A-Line Dress', 1299.00, 'Comfortable A-line dress with cute floral print', 'https://images.cbazaar.com/images/green-cotton-printed-a-line-dress-for-girl-kids-kdgntcs43-u.jpg', 'Casual Girls Wear'),
(10, 'Casual Short Dress', 1099.00, 'Adorable cotton dress for daily wear', 'https://i.pinimg.com/originals/62/ca/39/62ca39acaf1046b93e6d7ef112e531b6.png', 'Casual Girls Wear'),
(11, 'Sequin Embellished Gown', 2499.00, 'Glamorous gown with sequin detailing and flared bottom', 'https://img.ltwebstatic.com/images3_spmp/2024/01/12/99/1705053406c3325591350176238e23efa68d118831_thumbnail_900x.jpg', 'Festive Girls Wear'),
(12, 'Traditional Sharara Set', 1999.00, 'Classic ethnic sharara suit set with dupatta', 'https://images.cbazaar.com/images/Kids-Girls-Green-Cotton-Sequins-N-Pink-Sharara-Set-KDGSLBS02212541-u.jpg', 'Festive Girls Wear'),
(13, 'Strawberry Print Frock', 799.00, 'Cute summer frock with strawberry print and puff sleeves', 'https://img.ltwebstatic.com/images3_pi/2023/06/23/16875016723b0a3e63029470fc1853fff00b412a78_thumbnail_600x.jpg', 'Girls Summer Wear'),
(14, 'Tropical Set', 949.00, 'Two-piece tropical floral crop top with shorts', 'https://i.pinimg.com/originals/29/06/e5/2906e54d5377f94a774ec1b937b7e252.jpg', 'Girls Summer Wear'),
(15, 'Cold Shoulder Party Dress', 1599.00, 'Stylish cold-shoulder dress with ruffled layers', 'https://i.pinimg.com/originals/9e/8e/8e/9e8e8e56a5be3021889df4efd0f93487.jpg', 'Girls Western Wear'),
(16, 'Frilly Net Gown', 1899.00, 'Layered frilly net gown with satin bow', 'https://images.cbazaar.com/images/flawless-pink-net-sequins-kids-girls-gown-kdgmtk1200pi-u.jpg', 'Girls Western Wear'),
(17, 'Printed Cotton Tunic', 799.00, 'Lightweight printed tunic ideal for casual outings', 'https://i.pinimg.com/originals/dd/e8/18/dde8188771a01fc2d3a977b166b94190.jpg', 'Casual Girls Wear'),
(18, 'Graphic T-shirt Set', 999.00, 'Graphic print tee with leggings', 'https://i.pinimg.com/originals/b4/1f/29/b41f2928098c3e6c52b1854a9ae98651.jpg', 'Casual Girls Wear'),
(19, 'Polka Dot Play Dress', 899.00, 'Adorable polka dot frock with flared bottom', 'https://i.pinimg.com/originals/9b/6f/dd/9b6fdd61adb31c2a5fdc4e55e5c4d6d0.jpg', 'Casual Girls Wear'),
(20, 'Hoodie with Pants', 1299.00, 'Cozy hoodie and jogger pants combo for everyday wear', 'https://i.pinimg.com/originals/19/4b/70/194b709b71a08a461e8243f8a8826acd.jpg', 'Casual Girls Wear'),
(21, 'Rainbow Print A-line Dress', 1099.00, 'Cute rainbow-printed dress for daily comfort', 'https://i.pinimg.com/originals/78/98/92/789892bd1f96b3ac500e3d008c294761.png', 'Casual Girls Wear'),
(22, 'Layered Cotton Skirt Set', 1150.00, 'Skirt with layers and matching cotton top', 'https://i.pinimg.com/736x/d4/ba/52/d4ba5259b2252dd8526ad8a5ab6a9d43.jpg', 'Casual Girls Wear'),
(23, 'Frilled Neck Top & Shorts', 949.00, 'Top with frill neckline and printed shorts', 'https://hk.tommy.com/dw/image/v2/BGLQ_PRD/on/demandware.static/-/Sites-th-master-catalog/default/dw84964e1e/KG07870/C34_01_KG0KG078700A7_MO-ST-F1.jpg?sw=1023&sh=1365&q=90', 'Casual Girls Wear'),
(24, 'Striped Knit Dress', 1199.00, 'Soft knit dress with colorful stripes', 'https://i.pinimg.com/originals/74/12/cd/7412cd69ae5a3cbbd2ba2a8a25552cd1.jpg', 'Casual Girls Wear'),
(25, 'Net Layered Party Gown', 2599.00, 'Gown with net layers', 'https://www.fayonkids.com/cdn/shop/products/fayon-kids-multi-colour-net-layers-gown-for-girls-36898189148416.jpg?v=1650373398', 'Festive Girls Wear'),
(26, 'Peplum Choli with Sharara', 1899.00, 'Trendy peplum choli with matching sharara', 'https://images.cbazaar.com/images/Kids-Girls-Kid-Girls-Peach-Art-Silk-Sharara-Set-KDGSLBS02306378-u.jpg', 'Festive Girls Wear'),
(27, 'Sequin Work Lehenga Set', 2499.00, 'Lehenga with sequin detailing and dupatta', 'https://i.pinimg.com/originals/46/30/81/463081720e9765ca85463310076331f4.jpg', 'Festive Girls Wear'),
(28, 'Angrakha Style Kurti Set', 1599.00, 'Angrakha style kurti with leggings and dupatta', 'https://5.imimg.com/data5/ECOM/Default/2024/1/374189867/EW/RZ/FD/8968532/tks165-1-1000x1000.jpg', 'Festive Girls Wear'),
(29, 'Heavy Embroidery Gown', 2899.00, 'Elegant gown with heavy embroidery and sequins', 'https://images.cbazaar.com/images/Kids-Girls-Kid-Girls-Wine-Embroidered-Handkerchief-Gown-KDGIWBS02302171-u.jpg', 'Festive Girls Wear'),
(30, 'Ghagra Set', 2299.00, 'Embroidered worked ghagra with blouse', 'https://static3.azafashions.com/uploads/product_gallery/1709045272654_1.jpg', 'Festive Girls Wear'),
(31, 'Royal Blue Silk Gown', 3099.00, 'Silk gown with flare', 'https://i.pinimg.com/736x/1a/bb/ff/1abbff613fbefd584e0659fb3c995112.jpg', 'Festive Girls Wear'),
(32, 'Pattu Pavadai', 1599.00, 'Traditional silk skirt and blouse', 'https://i.pinimg.com/originals/cf/fc/8a/cffc8a1314832b5c8882c0708835c2b1.jpg', 'Festive Girls Wear'),
(33, 'Linen Sundress', 849.00, 'Breathable linen sundress with colorful blocks', 'https://i.pinimg.com/736x/68/86/a6/6886a69bdc80f5e51c8b10606e1d06ce.jpg', 'Girls Summer Wear'),
(34, 'Tropical Printed Skirt Set', 999.00, 'Tropical printed skirt and crop top set', 'https://i.pinimg.com/originals/89/37/14/893714f2977edd3a31dd2362409dd16c.jpg', 'Girls Summer Wear'),
(35, 'Frill Sleeve Cotton Dress', 799.00, 'Simple cotton dress with frill sleeves', 'https://i.pinimg.com/originals/50/86/6b/50866b762907145cd516e3c3076e8afd.jpg', 'Girls Summer Wear'),
(36, 'Printed Jumpsuit', 1049.00, 'Printed cotton jumpsuit', 'https://i.pinimg.com/736x/bc/ce/10/bcce109884c70ae929732684235d21ca.jpg', 'Girls Summer Wear'),
(37, 'Summer Romper', 699.00, 'Zipper Back Double Gold Breasted Detail Romper', 'https://i.pinimg.com/originals/cd/79/4a/cd794aa321bc72fdfa2ad5150c5834fe.jpg', 'Girls Summer Wear'),
(38, 'Shorts & Sleeveless Top Set', 949.00, 'Colorful shorts with breezy top', 'https://cdn.shopify.com/s/files/1/0084/1954/1089/products/kids-breezy-shorts-160532_1800x1800.jpg?v=1627053619', 'Girls Summer Wear'),
(39, 'Ice Cream Print Skirt Dress', 799.00, 'Printed skirt dress with summer fun prints', 'https://www.rockies.co.nz/user/images/89138_1000_1000.jpg?t=2010091113', 'Girls Summer Wear'),
(40, 'Ruffle Shoulder Frock', 899.00, 'Lightweight frock with sleeves', 'https://i.pinimg.com/originals/a2/d9/4e/a2d94e2b86bfa2cc718145efb943f360.jpg', 'Girls Summer Wear'),
(41, 'Cold Shoulder Denim Dress', 1299.00, 'Trendy cold shoulder denim dress', 'https://i.pinimg.com/originals/9e/19/35/9e19354c9f4fe4fdf1f6dcf5689f9bba.jpg', 'Girls Western Wear'),
(42, 'Jeans & Top Set', 1499.00, 'Jeans with printed cotton top', 'https://i.pinimg.com/originals/55/c8/60/55c860080de17a54d05381429619537b.jpg', 'Girls Western Wear'),
(43, 'Sequin Party Dress', 1699.00, 'Glam sequin mini dress for parties', 'https://www.gap.com/webcontent/0027/602/045/cn27602045.jpg', 'Girls Western Wear'),
(44, 'Plaid Shirt & Shorts', 1099.00, 'Button-down plaid shirt with shorts', 'https://i.pinimg.com/originals/27/e5/33/27e533f1c67cea838d243152a461bfa1.jpg', 'Girls Western Wear'),
(45, 'Floral A-Line Skater Dress', 1299.00, 'Western-style floral skater dress', 'https://www.handrlondon.com/product_image/1673454363566%20K%20FRONT.jpg', 'Girls Western Wear'),
(46, 'Pinafore with Inner Top', 1149.00, 'Pinafore skirt with inner white top', 'https://i.pinimg.com/originals/33/82/b1/3382b161b02c5dc715cde1bd3aa44f3b.jpg', 'Girls Western Wear'),
(47, 'Boho Chic Fringe Dress', 1499.00, 'Trendy bohemian-style dress with fringe details', 'https://i.pinimg.com/originals/80/cd/a3/80cda321a13abcf169c9919edd49d5e1.jpg', 'Girls Western Wear'),
(48, 'Leather Jacket Look Set', 1899.00, 'Black faux leather jacket with skinny jeans', 'https://i.etsystatic.com/11463421/r/il/de4e29/1840161133/il_fullxfull.1840161133_rc6t.jpg', 'Girls Western Wear'),
(49, 'Ballet Flats', 899.00, 'Cute ballet flats for girls.', 'https://i.pinimg.com/originals/ff/f7/89/fff78903bcef6f95d3f1538e537dd2e0.jpg', 'Footwear'),
(50, 'Colorful Sneakers', 1099.00, 'Bright and fun sneakers for girls.', 'https://stylestryproductionwls47sou4z.cdn.e2enetworks.net/images/products/medium/56aeff2f8c8672a0b16719fba6c25f7ff188a240.webp', 'Footwear'),
(51, 'Glitter Sandals', 999.00, 'Sparkly sandals for festive occasions.', 'https://i.pinimg.com/originals/c2/20/69/c2206949424162d596c85dde17e16dbd.jpg', 'Footwear'),
(52, 'Floral Flip Flops', 399.00, 'Floral design flip flops.', 'https://www.bodenimages.com/productimages/r1aproductlarge/23gspr_c1437_mlt_d01.jpg', 'Footwear'),
(53, 'LED Light Shoes', 1399.00, 'Glowing shoes loved by kids.', 'https://i5.walmartimages.com/seo/Dyfzdhu-Light-Up-Shoes-For-Girls-Toddler-Led-Walking-Shoes-Girls-Kids-Children-Baby-Casual-Led-Shoes_cd5316c9-9c00-4fa0-b116-c1a61f082cf4.8517e328533237f3f84b597afd6508e4.jpeg', 'Footwear'),
(54, 'Bow Sandals', 799.00, 'Cute sandals with bow design.', 'https://cdn.shopify.com/s/files/1/0331/5645/products/C-750Fuchsia_1024x1024.jpg?v=1571266420', 'Footwear'),
(55, 'Colorful Sneakers', 1099.00, 'Trendy sneakers with bright colors.', 'https://thumbs.dreamstime.com/b/creative-bright-colorful-sneakers-light-blue-background-sports-fashion-concept-fashionable-326083613.jpg', 'Footwear'),
(56, 'Princess Shoes', 1199.00, 'Elegant shoes for parties.', 'https://i.pinimg.com/736x/c2/5e/e1/c25ee1c1a9e341f5c3bacedfad789b55.jpg', 'Footwear'),
(57, 'Winter Boots', 1499.00, 'Warm and fuzzy boots for winter.', 'https://i5.walmartimages.com/seo/Xijirk-Girls-Snow-Boots-Girls-Autumn-and-Winter-Snow-Boots-Thick-Soles-Non-Slip-Warm-Comfortable-Solid-Color-Zipper-Shoes-Size-13_fb8518f1-654f-478b-a0f1-352ec035f2ec.bc6152e8a25109f3964338cf4022602e.jpeg', 'Footwear'),
(58, 'Printed Crocs', 599.00, 'Soft and fun crocs.', 'https://i.pinimg.com/originals/42/42/5e/42425eaad6abeec006ff6a12e2d3a064.jpg', 'Footwear'),
(59, 'Velcro Sandals', 699.00, 'Easy-to-wear sandals.', 'https://img-lcwaikiki.mncdn.com/mnresize/1020/1360/pim/productimages/20231/6424061/v1/l_20231-s3fq15z4-lt4_a.jpg', 'Footwear'),
(60, 'Floral Hairband', 199.00, 'Stretchable hairband with fabric flowers for party wear.', 'https://www.childrensalonoutlet.com/media/catalog/product/cache/0/image/1000x1000/9df78eab33525d08d6e5fb8d27136e95/i/r/irpa-white-pink-floral-hairband-481364-78ca8949392485f98e5661e3ad8eccad0795c1b7.jpg', 'Accessories'),
(61, 'Kids Beaded Necklace', 249.00, 'Colorful beaded necklace with heart pendant.', 'https://i.etsystatic.com/8164206/c/2250/2250/0/57/il/2c7c80/6149976061/il_600x600.6149976061_fxhl.jpg', 'Accessories'),
(62, 'Pink Cat-Ear Hair Clips', 149.00, 'Pair of glittery cat-ear hair clips for fun looks.', 'https://i.etsystatic.com/36597970/r/il/8a4df1/4414079677/il_300x300.4414079677_41v1.jpg', 'Accessories'),
(63, 'Mini Crossbody Bag', 499.00, 'Stylish mini sling bag with cartoon patch for kids.', 'https://i.pinimg.com/originals/28/67/ea/2867ea7659765d8c555a23a3295234ff.jpg', 'Accessories'),
(64, 'Princess Tiara Headband', 299.00, 'Sparkly silver tiara headband for birthdays and parties.', 'https://i.pinimg.com/originals/a2/bb/b9/a2bbb9b24f2fdc6e9f87d56657205952.jpg', 'Accessories'),
(65, 'Cartoon Umbrella', 399.00, 'Kid-friendly umbrella with printed cartoon characters.', 'https://kidslicensing.com/wp-content/uploads/2023/04/PP17100-433x541.jpg', 'Accessories'),
(66, 'Glitter Handbag', 549.00, 'Small handbag with sequin sparkle for dressy outings.', 'https://www.miabellebaby.com/cdn/shop/files/78Reizing_20for_20listings_20_21.png?v=1721159868&width=1080', 'Accessories'),
(67, 'Rainbow Sunglasses', 299.00, 'Colorful kids sunglasses with UV protection.', 'https://api.carters.com/dw/image/v2/AAMK_PRD/on/demandware.static/-/Sites-carters_master_catalog/default/dw538a050d/productimages/CR07393.jpg?sw=1200', 'Accessories'),
(68, 'Butterfly Clip Set', 269.00, 'Set of 10 butterfly clips in assorted colors.', 'https://i.etsystatic.com/35998099/r/il/8b7a36/5647880053/il_1080xN.5647880053_8kdy.jpg', 'Accessories'),
(69, 'Unicorn Wristwatch', 599.00, 'Digital watch with unicorn print strap for young girls.', 'https://image.smythstoys.com/original/desktop/222815.jpg', 'Accessories');



-- Inserting data in coupons table

INSERT INTO coupons (code, description, discount_type, discount_value, min_order_amount, category) VALUES
('2BUY1599', '2 quantity for ₹1599 on orders between ₹1599 and ₹1899', 'special_price', 1599.00, 1599.00, NULL),
('B1G1', 'Buy 1 Get 1 Free on womenswear orders above ₹3499', 'b1g1', 0.00, 3499.00, 'womenswear'),
('FLAT50', '50% off on any category orders above ₹3999', 'percentage', 50.00, 3999.00, NULL),
('FREEDEL', 'Free shipping on orders above ₹999', 'free_shipping', 99.00, 999.00, NULL),
('NEWUSER', 'Flat ₹399 on first order', 'fixed', 399.00, 1199.00, NULL);
