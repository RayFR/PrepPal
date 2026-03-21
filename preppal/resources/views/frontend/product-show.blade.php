@extends('layouts.app')

@section('title', $product->name)

@section('content')
@php
  $reviewCount = $product->reviews->count();
  $avg = $reviewCount ? (float) ($averageRating ?? 0) : 0;
  $roundedStars = $reviewCount ? (int) round($avg) : 0;

  $mainImgPath = $product->image_path ?: 'images/whey_protein.png';

  $productSlug = strtolower(trim($product->name));
  $productCategory = strtolower(trim($product->category ?? ''));

  $isWheyProtein = $productSlug === 'whey protein 1kg';
  $isCreatine = $productSlug === 'creatine monohydrate 300g';
  $isPreWorkout = $productSlug === 'pre-workout jay cutler';
  $isBcaa = $productSlug === 'bcaa powder 250g';
  $isMultivitamin = $productSlug === 'daily multivitamin 60 tablets';

  // Clothing detection
  $isTank = str_contains($productSlug, 'tank');
  $isShorts = str_contains($productSlug, 'shorts');
  $isZip = str_contains($productSlug, 'zip');
  $isPants = str_contains($productSlug, 'jogger') || str_contains($productSlug, 'pants');
  $isGymGirlSet = str_contains($productSlug, 'gym girl set');
  $isClothing = $productCategory === 'clothing' || $isTank || $isShorts || $isZip || $isPants || $isGymGirlSet;

  $wheyFlavours = [
    'vanilla' => [
      'label' => 'Vanilla',
      'cart_name' => 'Whey Protein 1kg - Vanilla',
      'image' => asset('images/whey_proteinvanilla.png'),
      'gallery' => [
        asset('images/whey_proteinvanilla.png'),
      ],
    ],
    'banana' => [
      'label' => 'Banana',
      'cart_name' => 'Whey Protein 1kg - Banana',
      'image' => asset('images/whey_proteinban.png'),
      'gallery' => [
        asset('images/whey_proteinban.png'),
      ],
    ],
    'coffee' => [
      'label' => 'Coffee',
      'cart_name' => 'Whey Protein 1kg - Coffee',
      'image' => asset('images/whey_proteincafe.png'),
      'gallery' => [
        asset('images/whey_proteincafe.png'),
      ],
    ],
    'peanut_butter' => [
      'label' => 'Peanut Butter',
      'cart_name' => 'Whey Protein 1kg - Peanut Butter',
      'image' => asset('images/whey_protein.png'),
      'gallery' => [
        asset('images/whey_protein.png'),
      ],
    ],
    'chocolate' => [
      'label' => 'Chocolate',
      'cart_name' => 'Whey Protein 1kg - Chocolate',
      'image' => asset('images/whey_proteinchoc.png'),
      'gallery' => [
        asset('images/whey_proteinchoc.png'),
      ],
    ],
  ];

  $creatineFlavours = [
    'cool_blue' => [
      'label' => 'Cool Blue',
      'cart_name' => 'Creatine Monohydrate 300g - Cool Blue',
      'image' => asset('images/creatine_monohydrate.jpg'),
      'gallery' => [
        asset('images/creatine_monohydrate.jpg'),
        asset('images/creatine_monohydrate2.png'),
        asset('images/creatine_monohydrate-3.png'),
      ],
    ],
    'berry' => [
      'label' => 'Berry',
      'cart_name' => 'Creatine Monohydrate 300g - Berry',
      'image' => asset('images/creatine_monohydrateberry.png'),
      'gallery' => [
        asset('images/creatine_monohydrateberry.png'),
      ],
    ],
    'lime' => [
      'label' => 'Lime',
      'cart_name' => 'Creatine Monohydrate 300g - Lime',
      'image' => asset('images/creatine_monohydratelime.png'),
      'gallery' => [
        asset('images/creatine_monohydratelime.png'),
      ],
    ],
    'melon' => [
      'label' => 'Melon',
      'cart_name' => 'Creatine Monohydrate 300g - Melon',
      'image' => asset('images/creatine_monohydratemelon.png'),
      'gallery' => [
        asset('images/creatine_monohydratemelon.png'),
      ],
    ],
  ];

  $preWorkoutFlavours = [
    'grape' => [
      'label' => 'Grape',
      'cart_name' => 'Pre-workout Jay Cutler - Grape',
      'image' => asset('images/preworkoutjay.png'),
      'gallery' => [
        asset('images/preworkoutjay.png'),
      ],
    ],
    'pineapple' => [
      'label' => 'Pineapple',
      'cart_name' => 'Pre-workout Jay Cutler - Pineapple',
      'image' => asset('images/preworkoutpine.png'),
      'gallery' => [
        asset('images/preworkoutpine.png'),
      ],
    ],
    'lemon' => [
      'label' => 'Lemon',
      'cart_name' => 'Pre-workout Jay Cutler - Lemon',
      'image' => asset('images/preworkoutlemon.png'),
      'gallery' => [
        asset('images/preworkoutlemon.png'),
      ],
    ],
    'mango' => [
      'label' => 'Mango',
      'cart_name' => 'Pre-workout Jay Cutler - Mango',
      'image' => asset('images/preworkoutmango.png'),
      'gallery' => [
        asset('images/preworkoutmango.png'),
      ],
    ],
  ];

  $bcaaFlavours = [
    'fruit_punch' => [
      'label' => 'Fruit Punch',
      'cart_name' => 'BCAA Powder 250g - Fruit Punch',
      'image' => asset('images/bcaa_powder.jpg'),
      'gallery' => [
        asset('images/bcaa_powder.jpg'),
      ],
    ],
    'blueberry' => [
      'label' => 'Blueberry',
      'cart_name' => 'BCAA Powder 250g - Blueberry',
      'image' => asset('images/bcaa_powderblue.png'),
      'gallery' => [
        asset('images/bcaa_powderblue.png'),
      ],
    ],
  ];

  $clothingVariants = [];

  if ($isTank) {
    $clothingVariants = [
      'black_s' => [
        'label' => 'Black - Small',
        'cart_name' => 'PrepPal Performance Tank - Black / Small',
        'image' => asset('images/tanktop.png'),
        'gallery' => [
          asset('images/tanktop.png'),
        ],
      ],
      'black_m' => [
        'label' => 'Black - Medium',
        'cart_name' => 'PrepPal Performance Tank - Black / Medium',
        'image' => asset('images/tanktop.png'),
        'gallery' => [
          asset('images/tanktop.png'),
        ],
      ],
      'black_l' => [
        'label' => 'Black - Large',
        'cart_name' => 'PrepPal Performance Tank - Black / Large',
        'image' => asset('images/tanktop.png'),
        'gallery' => [
          asset('images/tanktop.png'),
        ],
      ],
      'black_xl' => [
        'label' => 'Black - XL',
        'cart_name' => 'PrepPal Performance Tank - Black / XL',
        'image' => asset('images/tanktop.png'),
        'gallery' => [
          asset('images/tanktop.png'),
        ],
      ],
    ];
  } elseif ($isShorts) {
    $clothingVariants = [
      'black_s' => [
        'label' => 'Black - Small',
        'cart_name' => 'PrepPal Training Shorts - Black / Small',
        'image' => asset('images/shortsfront.png'),
        'gallery' => [
          asset('images/shortsfront.png'),
          asset('images/shortsback.png'),
        ],
      ],
      'black_m' => [
        'label' => 'Black - Medium',
        'cart_name' => 'PrepPal Training Shorts - Black / Medium',
        'image' => asset('images/shortsfront.png'),
        'gallery' => [
          asset('images/shortsfront.png'),
          asset('images/shortsback.png'),
        ],
      ],
      'black_l' => [
        'label' => 'Black - Large',
        'cart_name' => 'PrepPal Training Shorts - Black / Large',
        'image' => asset('images/shortsfront.png'),
        'gallery' => [
          asset('images/shortsfront.png'),
          asset('images/shortsback.png'),
        ],
      ],
      'black_xl' => [
        'label' => 'Black - XL',
        'cart_name' => 'PrepPal Training Shorts - Black / XL',
        'image' => asset('images/shortsfront.png'),
        'gallery' => [
          asset('images/shortsfront.png'),
          asset('images/shortsback.png'),
        ],
      ],
    ];
  } elseif ($isZip) {
    $clothingVariants = [
      'black_s' => [
        'label' => 'Black - Small',
        'cart_name' => 'PrepPal Zip Hoodie - Black / Small',
        'image' => asset('images/zipfront.png'),
        'gallery' => [
          asset('images/zipfront.png'),
          asset('images/zipback.png'),
        ],
      ],
      'black_m' => [
        'label' => 'Black - Medium',
        'cart_name' => 'PrepPal Zip Hoodie - Black / Medium',
        'image' => asset('images/zipfront.png'),
        'gallery' => [
          asset('images/zipfront.png'),
          asset('images/zipback.png'),
        ],
      ],
      'black_l' => [
        'label' => 'Black - Large',
        'cart_name' => 'PrepPal Zip Hoodie - Black / Large',
        'image' => asset('images/zipfront.png'),
        'gallery' => [
          asset('images/zipfront.png'),
          asset('images/zipback.png'),
        ],
      ],
      'black_xl' => [
        'label' => 'Black - XL',
        'cart_name' => 'PrepPal Zip Hoodie - Black / XL',
        'image' => asset('images/zipfront.png'),
        'gallery' => [
          asset('images/zipfront.png'),
          asset('images/zipback.png'),
        ],
      ],
    ];
  } elseif ($isPants) {
    $clothingVariants = [
      'black_s' => [
        'label' => 'Black - Small',
        'cart_name' => 'PrepPal Joggers - Black / Small',
        'image' => asset('images/pants.png'),
        'gallery' => [
          asset('images/pants.png'),
        ],
      ],
      'black_m' => [
        'label' => 'Black - Medium',
        'cart_name' => 'PrepPal Joggers - Black / Medium',
        'image' => asset('images/pants.png'),
        'gallery' => [
          asset('images/pants.png'),
        ],
      ],
      'black_l' => [
        'label' => 'Black - Large',
        'cart_name' => 'PrepPal Joggers - Black / Large',
        'image' => asset('images/pants.png'),
        'gallery' => [
          asset('images/pants.png'),
        ],
      ],
      'black_xl' => [
        'label' => 'Black - XL',
        'cart_name' => 'PrepPal Joggers - Black / XL',
        'image' => asset('images/pants.png'),
        'gallery' => [
          asset('images/pants.png'),
        ],
      ],
    ];
  } elseif ($isGymGirlSet) {
    $clothingVariants = [
      'black_s' => [
        'label' => 'Black - Small',
        'cart_name' => 'PrepPal Gym Girl Set - Black / Small',
        'image' => asset('images/gymgirlset.png'),
        'gallery' => [
          asset('images/gymgirlset.png'),
        ],
      ],
      'black_m' => [
        'label' => 'Black - Medium',
        'cart_name' => 'PrepPal Gym Girl Set - Black / Medium',
        'image' => asset('images/gymgirlset.png'),
        'gallery' => [
          asset('images/gymgirlset.png'),
        ],
      ],
      'black_l' => [
        'label' => 'Black - Large',
        'cart_name' => 'PrepPal Gym Girl Set - Black / Large',
        'image' => asset('images/gymgirlset.png'),
        'gallery' => [
          asset('images/gymgirlset.png'),
        ],
      ],
      'black_xl' => [
        'label' => 'Black - XL',
        'cart_name' => 'PrepPal Gym Girl Set - Black / XL',
        'image' => asset('images/gymgirlset.png'),
        'gallery' => [
          asset('images/gymgirlset.png'),
        ],
      ],
    ];
  }

  $activeFlavours = $isClothing
    ? $clothingVariants
    : ($isWheyProtein
        ? $wheyFlavours
        : ($isCreatine
            ? $creatineFlavours
            : ($isPreWorkout
                ? $preWorkoutFlavours
                : ($isBcaa ? $bcaaFlavours : []))));

  $defaultFlavourKey = $isClothing
    ? (count($clothingVariants) ? array_key_first($clothingVariants) : null)
    : ($isWheyProtein
        ? 'vanilla'
        : ($isCreatine
            ? 'berry'
            : ($isPreWorkout
                ? 'grape'
                : ($isBcaa ? 'fruit_punch' : null))));
@endphp

<main class="container main-content">

  <nav class="pp-breadcrumb">
    <a href="{{ url('/') }}">Home</a>
    <span>/</span>
    <a href="{{ route('store') }}">Store</a>
    <span>/</span>
    <span class="pp-crumb-current">{{ $product->name }}</span>
  </nav>

  <div class="pp-pdp">

    <section class="pp-pdp-left">

      <style>
        .pp-gal {
          display: grid;
          gap: 12px;
        }

        .pp-gal-frame{
          position: relative;
          overflow: hidden;
          border-radius: 18px;
          background: rgba(255,255,255,.04);
          border: 1px solid rgba(255,255,255,.10);
          box-shadow: 0 18px 50px rgba(0,0,0,.25);
          display: flex;
          align-items: center;
          justify-content: center;
          min-height: 0;
        }

        body:not([data-theme="dark"]) .pp-gal-frame{
          background: rgba(0,0,0,.02);
          border: 1px solid rgba(0,0,0,.08);
          box-shadow: 0 18px 50px rgba(0,0,0,.10);
        }

        .pp-gal-viewport{
          overflow: hidden;
          width: 100%;
        }

        .pp-gal-track{
          display: flex;
          width: 100%;
          will-change: transform;
          transition: transform .35s ease;
          touch-action: pan-y;
        }

        .pp-gal-slide{
          min-width: 100%;
          display: flex;
          align-items: center;
          justify-content: center;
        }

        .pp-gal-img{
          width: 100%;
          max-width: 720px;
          height: auto;
          max-height: 720px;
          object-fit: contain;
          object-position: center;
          display: block;
          margin: 0 auto;
          background: transparent;
          padding: 0;
          box-sizing: border-box;
        }

        @media (max-width: 980px){
          .pp-gal-img{
            max-width: 100%;
            max-height: 560px;
          }
        }

        @media (max-width: 520px){
          .pp-gal-img{
            max-height: 420px;
          }
        }

        .pp-gal-nav{
          position: absolute;
          top: 50%;
          transform: translateY(-50%);
          width: 46px;
          height: 46px;
          border-radius: 12px;
          border: 1px solid rgba(255,255,255,.16);
          background: rgba(0,0,0,.38);
          color: #fff;
          font-size: 28px;
          line-height: 1;
          display: grid;
          place-items: center;
          cursor: pointer;
          z-index: 5;
          opacity: 0;
          transition: opacity .18s ease;
        }

        .pp-gal-frame:hover .pp-gal-nav{ opacity: 1; }
        .pp-gal-prev{ left: 12px; }
        .pp-gal-next{ right: 12px; }
        .pp-gal-nav[disabled]{ opacity: .25 !important; cursor: not-allowed; }

        .pp-gal-dots{
          position: absolute;
          left: 50%;
          bottom: 12px;
          transform: translateX(-50%);
          display: flex;
          gap: 6px;
          z-index: 5;
        }

        .pp-gal-dot{
          width: 7px;
          height: 7px;
          border-radius: 999px;
          background: rgba(255,255,255,.35);
          border: 1px solid rgba(255,255,255,.25);
        }

        .pp-gal-dot.is-active{
          background: rgba(255,140,0,.95);
          border-color: rgba(255,140,0,.65);
        }

        .pp-gal-thumbs{
          display: flex;
          gap: 10px;
          overflow: auto;
          padding-bottom: 4px;
          scrollbar-width: thin;
        }

        .pp-gal-thumb{
          flex: 0 0 auto;
          width: 86px;
          height: 86px;
          border-radius: 14px;
          overflow: hidden;
          border: 1px solid rgba(255,255,255,.14);
          background: rgba(255,255,255,.05);
          cursor: pointer;
          padding: 0;
        }

        body:not([data-theme="dark"]) .pp-gal-thumb{
          border: 1px solid rgba(0,0,0,.10);
          background: rgba(0,0,0,.02);
        }

        .pp-gal-thumb img{
          width: 100%;
          height: 100%;
          object-fit: cover;
          display: block;
        }

        .pp-gal-thumb.is-active{
          outline: 2px solid rgba(255,140,0,.65);
          outline-offset: 2px;
        }

        .pp-option-group{
          margin: 18px 0 10px;
        }

        .pp-option-label{
          display: block;
          font-weight: 700;
          margin-bottom: 10px;
          color: inherit;
        }

        .pp-option-select{
          width: 100%;
          height: 54px;
          border-radius: 14px;
          border: 1px solid rgba(255,255,255,.12);
          background: #0f1830;
          color: #ffffff;
          padding: 0 16px;
          font-size: 1rem;
          font-weight: 600;
          outline: none;
        }

        .pp-option-select option{
          background: #0f1830;
          color: #ffffff;
        }

        body:not([data-theme="dark"]) .pp-option-select{
          border: 1px solid rgba(0,0,0,.10);
          background: #ffffff;
          color: #111827;
        }

        body:not([data-theme="dark"]) .pp-option-select option{
          background: #ffffff;
          color: #111827;
        }

        .pp-selected-flavour{
          margin-top: 8px;
          font-size: .95rem;
          opacity: .85;
        }

        .pp-size-guide-btn{
          margin-top: 12px;
          border: 1px solid rgba(255,140,0,.35);
          background: transparent;
          color: #ff8c00;
          border-radius: 12px;
          padding: 10px 14px;
          font-weight: 700;
          cursor: pointer;
          transition: .2s ease;
        }

        .pp-size-guide-btn:hover{
          background: rgba(255,140,0,.08);
        }

        .pp-size-guide-modal{
          position: fixed;
          inset: 0;
          z-index: 9999;
          display: none;
        }

        .pp-size-guide-modal.is-open{
          display: block;
        }

        .pp-size-guide-backdrop{
          position: absolute;
          inset: 0;
          background: rgba(0,0,0,.65);
        }

        .pp-size-guide-panel{
          position: relative;
          width: min(720px, calc(100% - 32px));
          margin: 6vh auto 0;
          background: #0f1830;
          color: #fff;
          border: 1px solid rgba(255,255,255,.12);
          border-radius: 20px;
          box-shadow: 0 24px 80px rgba(0,0,0,.35);
          padding: 24px;
          z-index: 2;
        }

        body:not([data-theme="dark"]) .pp-size-guide-panel{
          background: #ffffff;
          color: #111827;
          border: 1px solid rgba(0,0,0,.08);
        }

        .pp-size-guide-close{
          position: absolute;
          top: 12px;
          right: 12px;
          width: 40px;
          height: 40px;
          border-radius: 10px;
          border: 1px solid rgba(255,255,255,.12);
          background: rgba(255,255,255,.06);
          color: inherit;
          font-size: 24px;
          line-height: 1;
          cursor: pointer;
        }

        body:not([data-theme="dark"]) .pp-size-guide-close{
          border: 1px solid rgba(0,0,0,.10);
          background: rgba(0,0,0,.03);
        }

        .pp-size-guide-text,
        .pp-size-guide-note{
          opacity: .9;
          margin-top: 10px;
        }

        .pp-size-guide-table-wrap{
          overflow-x: auto;
          margin-top: 16px;
          border-radius: 14px;
        }

        .pp-size-guide-table{
          width: 100%;
          border-collapse: collapse;
          min-width: 520px;
        }

        .pp-size-guide-table th,
        .pp-size-guide-table td{
          text-align: left;
          padding: 14px 16px;
          border-bottom: 1px solid rgba(255,255,255,.10);
        }

        body:not([data-theme="dark"]) .pp-size-guide-table th,
        body:not([data-theme="dark"]) .pp-size-guide-table td{
          border-bottom: 1px solid rgba(0,0,0,.08);
        }

        .pp-size-guide-table th{
          color: #ff8c00;
          font-weight: 800;
        }

        .pp-nutrition{
          margin-top: 12px;
        }

        .pp-nutrition p{
          margin: 0 0 10px;
        }

        .pp-nutrition-table-wrap{
          overflow-x: auto;
          margin-top: 14px;
          border-radius: 14px;
        }

        .pp-nutrition-table{
          width: 100%;
          border-collapse: collapse;
          min-width: 520px;
        }

        .pp-nutrition-table th,
        .pp-nutrition-table td{
          text-align: left;
          padding: 14px 16px;
          border-bottom: 1px solid rgba(255,255,255,.10);
        }

        body:not([data-theme="dark"]) .pp-nutrition-table th,
        body:not([data-theme="dark"]) .pp-nutrition-table td{
          border-bottom: 1px solid rgba(0,0,0,.08);
        }

        .pp-nutrition-table th{
          color: #ff8c00;
          font-weight: 800;
        }

        .pp-demo-note{
          color: #ffb15c;
          font-size: .95rem;
        }
      </style>

      <div
        class="pp-gal"
        data-pp-gal
        data-main-src="{{ asset($mainImgPath) }}"
        data-is-whey="{{ $isWheyProtein ? '1' : '0' }}"
        data-is-creatine="{{ $isCreatine ? '1' : '0' }}"
        data-is-preworkout="{{ $isPreWorkout ? '1' : '0' }}"
        data-is-bcaa="{{ $isBcaa ? '1' : '0' }}"
        data-is-clothing="{{ $isClothing ? '1' : '0' }}"
        data-default-flavour="{{ $defaultFlavourKey }}"
        data-flavour-images='@json($activeFlavours)'
      >
        <div class="pp-gal-frame">
          <button type="button" class="pp-gal-nav pp-gal-prev" data-pp-gal-prev aria-label="Previous image">‹</button>

          <div class="pp-gal-viewport" data-pp-gal-viewport>
            <div class="pp-gal-track" data-pp-gal-track></div>
          </div>

          <button type="button" class="pp-gal-nav pp-gal-next" data-pp-gal-next aria-label="Next image">›</button>

          <div class="pp-gal-dots" data-pp-gal-dots aria-label="Gallery dots"></div>
        </div>

        <div class="pp-gal-thumbs" data-pp-gal-thumbs aria-label="Gallery thumbnails"></div>
      </div>

    </section>

    <aside class="pp-pdp-right">
      <h1 class="pp-title">{{ $product->name }}</h1>
      <p class="pp-subtitle">
        @if($isClothing)
          Clothing
        @elseif($product->category === 'meal')
          Meal Prep Plan
        @else
          Supplement
        @endif
      </p>

      <div class="pp-rating">
        <span class="pp-stars">
          @for ($i = 1; $i <= 5; $i++)
            {{ $i <= $roundedStars ? '★' : '☆' }}
          @endfor
        </span>

        @if ($reviewCount)
          <span class="pp-rating-text">{{ number_format($avg, 1) }} ({{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }})</span>
        @else
          <span class="pp-rating-text">No reviews yet</span>
        @endif
      </div>

      <div class="pp-price-row">
        <div class="pp-price">
          <span
            data-money-gbp="{{ $product->price }}"
            data-money-suffix="{{ $product->category === 'meal' ? ' / week' : '' }}"
          >£{{ number_format($product->price, 2) }}{{ $product->category === 'meal' ? ' / week' : '' }}</span>
        </div>
        <div class="pp-stock">
          @if(isset($product->stock) && $product->stock <= 0)
            Out of stock
          @elseif(isset($product->stock) && isset($product->low_stock_threshold) && $product->stock <= $product->low_stock_threshold)
            Low stock
          @else
            In stock
          @endif
        </div>
      </div>

      <ul class="pp-benefits">
        @if($isClothing)
          <li>Comfortable training fit</li>
          <li>Designed for gym and casual wear</li>
          <li>Signature PrepPal branding</li>
        @elseif($product->category === 'meal')
          <li>Goal-based weekly plan</li>
          <li>Macro-friendly & portion-controlled</li>
          <li>Pause or cancel anytime</li>
        @else
          <li>Pairs well with your meal plan</li>
          <li>Routine-friendly dosing</li>
          <li>Great value per serving</li>
        @endif
      </ul>

      @if($isWheyProtein || $isCreatine || $isPreWorkout || $isBcaa)
        <div class="pp-option-group">
          <label for="ppFlavourSelect" class="pp-option-label">Flavour:</label>
          <select id="ppFlavourSelect" class="pp-option-select">
            @foreach($activeFlavours as $key => $flavour)
              <option value="{{ $key }}" {{ $key === $defaultFlavourKey ? 'selected' : '' }}>
                {{ $flavour['label'] }}
              </option>
            @endforeach
          </select>
          <div class="pp-selected-flavour" id="ppSelectedFlavour">
            Selected flavour: {{ $defaultFlavourKey && isset($activeFlavours[$defaultFlavourKey]) ? $activeFlavours[$defaultFlavourKey]['label'] : 'None' }}
          </div>
        </div>
      @endif

      @if($isClothing && count($activeFlavours))
        <div class="pp-option-group">
          <label for="ppSizeSelect" class="pp-option-label">Size:</label>
          <select id="ppSizeSelect" class="pp-option-select">
            @foreach($activeFlavours as $key => $variant)
              <option value="{{ $key }}" {{ $key === $defaultFlavourKey ? 'selected' : '' }}>
                {{ $variant['label'] }}
              </option>
            @endforeach
          </select>

          <div class="pp-selected-flavour" id="ppSelectedSize">
            Selected size: {{ $defaultFlavourKey && isset($activeFlavours[$defaultFlavourKey]) ? $activeFlavours[$defaultFlavourKey]['label'] : 'None' }}
          </div>

          <button type="button" class="pp-size-guide-btn" id="ppSizeGuideOpen">
            View size guide
          </button>
        </div>
      @endif

      <div class="pp-actions">
        <div class="pp-qty">
          <button type="button" class="pp-qty-btn" data-qty="-1" aria-label="Decrease quantity">−</button>
          <input class="pp-qty-input" type="number" min="1" value="1">
          <button type="button" class="pp-qty-btn" data-qty="+1" aria-label="Increase quantity">+</button>
        </div>

        <button
          type="button"
          class="cta pp-add add-to-cart"
          data-id="{{ $product->id }}"
          data-name="{{ count($activeFlavours) && $defaultFlavourKey && isset($activeFlavours[$defaultFlavourKey]) ? $activeFlavours[$defaultFlavourKey]['cart_name'] : $product->name }}"
          data-base-name="{{ $product->name }}"
          data-price="{{ $product->price }}"
          data-image="{{ count($activeFlavours) && $defaultFlavourKey && isset($activeFlavours[$defaultFlavourKey]) ? $activeFlavours[$defaultFlavourKey]['image'] : asset($product->image_path) }}"
          data-qty="1"
          data-variant="{{ count($activeFlavours) && $defaultFlavourKey && isset($activeFlavours[$defaultFlavourKey]) ? $activeFlavours[$defaultFlavourKey]['label'] : '' }}"
          @if(isset($product->stock) && $product->stock <= 0) disabled @endif
        >
          @if(isset($product->stock) && $product->stock <= 0)
            Out of stock
          @else
            Add to cart
          @endif
        </button>
      </div>

      <div class="pp-trust">
        <div class="pp-trust-item">✅ Quality checked</div>
        <div class="pp-trust-item">🚚 Fast UK delivery</div>
        <div class="pp-trust-item">🔒 Secure checkout</div>
      </div>

      <div class="pp-ship">
        <div class="pp-ship-row"><span>🚚</span> <strong>Delivery:</strong>&nbsp;2–4 working days (UK)</div>
        <div class="pp-ship-row"><span>↩️</span> <strong>Returns:</strong>&nbsp;14-day returns on unopened items</div>
      </div>

      <div class="pp-accordion">
        <details open>
          <summary>Description</summary>
          <p>{{ $product->description }}</p>
        </details>

        @if(!str_starts_with((string) $product->id, 'clothing-'))
          <details>
            <summary>Write a Review</summary>

            @if(session('success'))
              <p style="color: green; margin: 10px 0;">
                {{ session('success') }}
              </p>
            @endif

            <form method="POST" action="/products/{{ $product->id }}/reviews" class="pp-review-form">
              @csrf

              <div class="pp-review-field">
                <label>Rating</label>
                <select name="rating" required>
                  <option value="5">⭐⭐⭐⭐⭐</option>
                  <option value="4">⭐⭐⭐⭐</option>
                  <option value="3">⭐⭐⭐</option>
                  <option value="2">⭐⭐</option>
                  <option value="1">⭐</option>
                </select>
              </div>

              <div class="pp-review-field">
                <textarea name="comment" placeholder="Write your review (optional)"></textarea>
              </div>

              <button type="submit" class="cta pp-review-submit">
                Submit Review
              </button>
            </form>
          </details>
        @endif

        <section class="pp-reviews">
          <h3 class="pp-reviews-title">
            Customer Reviews ({{ $reviewCount }})
          </h3>

          @if ($product->reviews->isEmpty())
            <p class="pp-no-reviews">
              No reviews yet. Be the first to review this product.
            </p>
          @else
            @foreach ($product->reviews as $review)
              <article class="pp-review-card">
                <div class="pp-review-header">
                  <strong class="pp-review-user">
                    {{ $review->user->name ?? 'Customer' }}
                  </strong>

                  <span class="pp-review-stars">
                    @for ($i = 1; $i <= 5; $i++)
                      {{ $i <= $review->rating ? '★' : '☆' }}
                    @endfor
                  </span>
                </div>

                @if ($review->comment)
                  <p class="pp-review-comment">
                    {{ $review->comment }}
                  </p>
                @endif

                <div class="pp-review-meta">
                  Reviewed {{ optional($review->created_at)->diffForHumans() ?? 'recently' }}
                </div>

                @if (auth()->id() === ($review->user_id ?? null))
                  <div class="pp-review-actions">
                    <a href="{{ route('reviews.edit', $review->id) }}" class="pp-review-edit">Edit</a>

                    <span>·</span>
                    <form method="POST" action="{{ route('reviews.destroy', $review->id) }}" class="pp-review-delete">
                      @csrf
                      @method('DELETE')
                      <button type="submit">Delete</button>
                    </form>
                  </div>
                @endif
              </article>
            @endforeach
          @endif
        </section>

        <details>
          <summary>How to use</summary>
          <p>
            @if($isClothing)
              Select your size, add to cart, and pair it with your training routine.
            @elseif($product->category === 'meal')
              Choose your plan, order weekly, track progress — pause/cancel before next billing.
            @else
              Follow label directions. Use consistently and stay hydrated.
            @endif
          </p>
        </details>

        @if($isWheyProtein)
          <details>
            <summary>Nutritional Information</summary>

            <div class="pp-nutrition">
              <p><strong>Serving Size:</strong> 30g</p>
              <p><strong>Protein Per Serving:</strong> 25g</p>
              <p><strong>Suitable for all flavours:</strong> Vanilla, Banana, Coffee, Chocolate, Peanut Butter</p>

              <div class="pp-nutrition-table-wrap">
                <table class="pp-nutrition-table">
                  <thead>
                    <tr>
                      <th>Typical Values</th>
                      <th>Per 100g</th>
                      <th>Per 30g</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>Energy</td><td>1597kJ</td><td>479kJ</td></tr>
                    <tr><td>Energy</td><td>378kcal</td><td>113kcal</td></tr>
                    <tr><td>Fat</td><td>6.0g</td><td>1.8g</td></tr>
                    <tr><td>of which saturates</td><td>3.7g</td><td>1.1g</td></tr>
                    <tr><td>Carbohydrate</td><td>7.5g</td><td>2.2g</td></tr>
                    <tr><td>of which sugars</td><td>5.1g</td><td>1.5g</td></tr>
                    <tr><td>Protein</td><td>83.3g</td><td>25g</td></tr>
                    <tr><td>Salt</td><td>0.46g</td><td>0.14g</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </details>
        @endif

        @if($isCreatine)
          <details>
            <summary>Nutritional Information</summary>

            <div class="pp-nutrition">
              <p><strong>Serving Size:</strong> 5g</p>
              <p><strong>Creatine Per Serving:</strong> 4.5g</p>
              <p><strong>Suitable for all flavours:</strong> Cool Blue, Berry, Lime, Melon</p>

              <div class="pp-nutrition-table-wrap">
                <table class="pp-nutrition-table">
                  <thead>
                    <tr>
                      <th>Typical Values</th>
                      <th>Per 100g</th>
                      <th>Per 5g</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>Energy</td><td>1540kJ</td><td>77kJ</td></tr>
                    <tr><td>Energy</td><td>362kcal</td><td>18kcal</td></tr>
                    <tr><td>Fat</td><td>0.2g</td><td>0.0g</td></tr>
                    <tr><td>of which saturates</td><td>0.1g</td><td>0.0g</td></tr>
                    <tr><td>Carbohydrate</td><td>3.0g</td><td>0.2g</td></tr>
                    <tr><td>of which sugars</td><td>1.0g</td><td>0.1g</td></tr>
                    <tr><td>Protein</td><td>0.0g</td><td>0.0g</td></tr>
                    <tr><td>Salt</td><td>0.10g</td><td>0.01g</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </details>
        @endif

        @if($isPreWorkout)
          <details>
            <summary>Nutritional Information</summary>

            <div class="pp-nutrition">
              <p><strong>Serving Size:</strong> 20g</p>
              <p><strong>Active Blend Per Serving:</strong> 15g</p>
              <p><strong>Caffeine Per Serving:</strong> 220mg</p>
              <p><strong>Suitable for all flavours:</strong> Grape, Pineapple, Lemon, Mango</p>

              <div class="pp-nutrition-table-wrap">
                <table class="pp-nutrition-table">
                  <thead>
                    <tr>
                      <th>Typical Values</th>
                      <th>Per 100g</th>
                      <th>Per 20g</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>Energy</td><td>1480kJ</td><td>296kJ</td></tr>
                    <tr><td>Energy</td><td>350kcal</td><td>70kcal</td></tr>
                    <tr><td>Fat</td><td>0.5g</td><td>0.1g</td></tr>
                    <tr><td>of which saturates</td><td>0.1g</td><td>0.0g</td></tr>
                    <tr><td>Carbohydrate</td><td>12.0g</td><td>2.4g</td></tr>
                    <tr><td>of which sugars</td><td>4.0g</td><td>0.8g</td></tr>
                    <tr><td>Protein</td><td>5.0g</td><td>1.0g</td></tr>
                    <tr><td>Salt</td><td>0.60g</td><td>0.12g</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </details>
        @endif

        @if($isBcaa)
          <details>
            <summary>Nutritional Information</summary>

            <div class="pp-nutrition">
              <p><strong>Serving Size:</strong> 12g</p>
              <p><strong>BCAAs Per Serving:</strong> 7g</p>
              <p><strong>Suitable for all flavours:</strong> Fruit Punch, Blueberry</p>

              <div class="pp-nutrition-table-wrap">
                <table class="pp-nutrition-table">
                  <thead>
                    <tr>
                      <th>Typical Values</th>
                      <th>Per 100g</th>
                      <th>Per 12g</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>Energy</td><td>1420kJ</td><td>170kJ</td></tr>
                    <tr><td>Energy</td><td>335kcal</td><td>40kcal</td></tr>
                    <tr><td>Fat</td><td>0.1g</td><td>0.0g</td></tr>
                    <tr><td>of which saturates</td><td>0.0g</td><td>0.0g</td></tr>
                    <tr><td>Carbohydrate</td><td>8.0g</td><td>1.0g</td></tr>
                    <tr><td>of which sugars</td><td>2.0g</td><td>0.2g</td></tr>
                    <tr><td>Protein</td><td>58.0g</td><td>7.0g</td></tr>
                    <tr><td>Salt</td><td>0.20g</td><td>0.02g</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </details>
        @endif

        @if($isMultivitamin)
          <details>
            <summary>Nutritional Information</summary>

            <div class="pp-nutrition">
              <p><strong>Serving Size:</strong> 1 tablet</p>
              <p><strong>Servings Per Container:</strong> 60</p>

              <div class="pp-nutrition-table-wrap">
                <table class="pp-nutrition-table">
                  <thead>
                    <tr>
                      <th>Nutrient</th>
                      <th>Per Tablet</th>
                      <th>% NRV</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>Vitamin A</td><td>800µg</td><td>100%</td></tr>
                    <tr><td>Vitamin D</td><td>5µg</td><td>100%</td></tr>
                    <tr><td>Vitamin E</td><td>12mg</td><td>100%</td></tr>
                    <tr><td>Vitamin C</td><td>80mg</td><td>100%</td></tr>
                    <tr><td>Thiamin (B1)</td><td>1.1mg</td><td>100%</td></tr>
                    <tr><td>Riboflavin (B2)</td><td>1.4mg</td><td>100%</td></tr>
                    <tr><td>Niacin</td><td>16mg</td><td>100%</td></tr>
                    <tr><td>Vitamin B6</td><td>1.4mg</td><td>100%</td></tr>
                    <tr><td>Folic Acid</td><td>200µg</td><td>100%</td></tr>
                    <tr><td>Vitamin B12</td><td>2.5µg</td><td>100%</td></tr>
                    <tr><td>Biotin</td><td>50µg</td><td>100%</td></tr>
                    <tr><td>Pantothenic Acid</td><td>6mg</td><td>100%</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </details>
        @endif

        <details>
          <summary>FAQs</summary>
          <p><strong>When will my order arrive?</strong><br>Usually 2–4 working days.</p>
          <p><strong>Can I cancel a plan?</strong><br>Yes, before your next billing.</p>
        </details>
      </div>
    </aside>

  </div>

  @if($isClothing)
    <div class="pp-size-guide-modal" id="ppSizeGuideModal" aria-hidden="true">
      <div class="pp-size-guide-backdrop" data-size-guide-close></div>

      <div class="pp-size-guide-panel" role="dialog" aria-modal="true" aria-labelledby="ppSizeGuideTitle">
        <button type="button" class="pp-size-guide-close" id="ppSizeGuideClose" aria-label="Close size guide">
          ×
        </button>

        <h3 id="ppSizeGuideTitle">Size Guide</h3>
        <p class="pp-size-guide-text">
          Use this as a general guide for fit. If you prefer an oversized fit, go one size up.
        </p>

        <div class="pp-size-guide-table-wrap">
          <table class="pp-size-guide-table">
            <thead>
              <tr>
                <th>Size</th>
                <th>Chest</th>
                <th>Waist</th>
                <th>UK Fit</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Small</td>
                <td>34–36"</td>
                <td>28–30"</td>
                <td>S</td>
              </tr>
              <tr>
                <td>Medium</td>
                <td>38–40"</td>
                <td>30–32"</td>
                <td>M</td>
              </tr>
              <tr>
                <td>Large</td>
                <td>42–44"</td>
                <td>34–36"</td>
                <td>L</td>
              </tr>
              <tr>
                <td>XL</td>
                <td>46–48"</td>
                <td>38–40"</td>
                <td>XL</td>
              </tr>
            </tbody>
          </table>
        </div>

        <p class="pp-size-guide-note">
          For leggings, shorts, joggers, and fitted sets, use waist as the main reference. For tanks and hoodies, use chest as the main reference.
        </p>
      </div>
    </div>
  @endif
</main>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const GALLERY_BY_MAIN = {
      "whey_protein.png": [
        "/images/whey_protein.png",
        "/images/whey_protein2.png",
        "/images/whey_protien3.png"
      ],
      "creatine_monohydrate.jpg": [
        "/images/creatine_monohydrate.jpg",
        "/images/creatine_monohydrate2.png",
        "/images/creatine_monohydrate-3.png"
      ],
      "creatine_monohydrate2.png": [
        "/images/creatine_monohydrate.jpg",
        "/images/creatine_monohydrate2.png",
        "/images/creatine_monohydrate-3.png"
      ],
      "creatine_monohydrate-3.png": [
        "/images/creatine_monohydrate.jpg",
        "/images/creatine_monohydrate2.png",
        "/images/creatine_monohydrate-3.png"
      ],
      "bcaa_powder.jpg": ["/images/bcaa_powder.jpg"],
      "multivitimins.jpg": ["/images/multivitimins.jpg"],
      "fat_loss_plan.png": ["/images/fat_loss_plan.png"],
      "lean_muscle_plan.jpg": ["/images/lean_muscle_plan.jpg"],
      "maintainance_plan.jpg": ["/images/maintainance_plan.jpg"],
      "high_fibre_plan.jpg": ["/images/high_fibre_plan.jpg"],
      "tanktop.png": ["/images/tanktop.png"],
      "shortsfront.png": ["/images/shortsfront.png", "/images/shortsback.png"],
      "shortsback.png": ["/images/shortsfront.png", "/images/shortsback.png"],
      "zipfront.png": ["/images/zipfront.png", "/images/zipback.png"],
      "zipback.png": ["/images/zipfront.png", "/images/zipback.png"],
      "pants.png": ["/images/pants.png"],
      "gymgirlset.png": ["/images/gymgirlset.png"]
    };

    function uniq(arr) {
      const s = new Set();
      return arr.filter(x => {
        const k = String(x || '').trim();
        if (!k || s.has(k)) return false;
        s.add(k);
        return true;
      });
    }

    function fileFromUrl(u) {
      const clean = String(u || '').split('?')[0];
      return clean.split('/').pop();
    }

    document.querySelectorAll('[data-pp-gal]').forEach(root => {
      const mainSrc = root.getAttribute('data-main-src') || '';
      const isWhey = root.getAttribute('data-is-whey') === '1';
      const isCreatine = root.getAttribute('data-is-creatine') === '1';
      const isPreWorkout = root.getAttribute('data-is-preworkout') === '1';
      const isBcaa = root.getAttribute('data-is-bcaa') === '1';
      const isClothing = root.getAttribute('data-is-clothing') === '1';
      const usesVariantGallery = isWhey || isCreatine || isPreWorkout || isBcaa || isClothing;
      const defaultVariant = root.getAttribute('data-default-flavour') || '';

      let flavourConfig = {};
      try {
        flavourConfig = JSON.parse(root.getAttribute('data-flavour-images') || '{}');
      } catch (e) {
        flavourConfig = {};
      }

      const track = root.querySelector('[data-pp-gal-track]');
      const thumbs = root.querySelector('[data-pp-gal-thumbs]');
      const dots = root.querySelector('[data-pp-gal-dots]');
      const prevBtn = root.querySelector('[data-pp-gal-prev]');
      const nextBtn = root.querySelector('[data-pp-gal-next]');
      const viewport = root.querySelector('[data-pp-gal-viewport]');

      if (!track || !viewport || !thumbs || !dots) return;

      let imgs = [];
      let index = 0;
      let paused = false;
      let timer = null;

      function currentImagesForVariant(variantKey) {
        if (usesVariantGallery && variantKey && flavourConfig[variantKey]) {
          if (Array.isArray(flavourConfig[variantKey].gallery) && flavourConfig[variantKey].gallery.length) {
            return uniq(flavourConfig[variantKey].gallery);
          }

          if (flavourConfig[variantKey].image) {
            return [flavourConfig[variantKey].image];
          }
        }

        const mainFile = fileFromUrl(mainSrc);
        return uniq((GALLERY_BY_MAIN[mainFile] || [mainSrc]));
      }

      function setActiveUI() {
        thumbs.querySelectorAll('.pp-gal-thumb').forEach((b, i) => b.classList.toggle('is-active', i === index));
        dots.querySelectorAll('.pp-gal-dot').forEach((d, i) => d.classList.toggle('is-active', i === index));

        const single = imgs.length <= 1;
        if (prevBtn) prevBtn.style.display = single ? 'none' : '';
        if (nextBtn) nextBtn.style.display = single ? 'none' : '';
        dots.style.display = single ? 'none' : '';
      }

      function render() {
        track.style.transform = `translateX(${-index * 100}%)`;
        setActiveUI();
      }

      function go(i) {
        const max = imgs.length - 1;
        index = Math.max(0, Math.min(max, i));
        render();
      }

      function next() {
        go(index >= imgs.length - 1 ? 0 : index + 1);
      }

      function prev() {
        go(index <= 0 ? imgs.length - 1 : index - 1);
      }

      function buildGallery(newImages) {
        imgs = uniq(newImages);
        index = 0;

        track.innerHTML = imgs.map(src => `
          <div class="pp-gal-slide">
            <img class="pp-gal-img" src="${src}" alt="Product image">
          </div>
        `).join('');

        thumbs.innerHTML = imgs.map((src, i) => `
          <button type="button" class="pp-gal-thumb ${i === 0 ? 'is-active' : ''}" data-go="${i}">
            <img src="${src}" alt="Thumb ${i + 1}">
          </button>
        `).join('');

        dots.innerHTML = imgs.length > 1 ? imgs.map((_, i) => `
          <span class="pp-gal-dot ${i === 0 ? 'is-active' : ''}" data-dot="${i}"></span>
        `).join('') : '';

        render();
      }

      prevBtn?.addEventListener('click', () => {
        paused = true;
        prev();
      });

      nextBtn?.addEventListener('click', () => {
        paused = true;
        next();
      });

      thumbs.addEventListener('click', (e) => {
        const b = e.target.closest('[data-go]');
        if (!b) return;
        paused = true;
        go(parseInt(b.dataset.go, 10) || 0);
      });

      root.addEventListener('mouseenter', () => paused = true);
      root.addEventListener('mouseleave', () => paused = false);

      let sx = 0;
      let sy = 0;
      let down = false;

      viewport.addEventListener('touchstart', (ev) => {
        const t = ev.touches[0];
        sx = t.clientX;
        sy = t.clientY;
        down = true;
        paused = true;
      }, { passive: true });

      viewport.addEventListener('touchend', (ev) => {
        if (!down) return;
        down = false;
        const t = ev.changedTouches[0];
        const dx = t.clientX - sx;
        const dy = t.clientY - sy;
        if (Math.abs(dy) > Math.abs(dx)) return;
        if (dx > 40) prev();
        if (dx < -40) next();
      }, { passive: true });

      function start() {
        stop();
        if (imgs.length <= 1) return;
        timer = setInterval(() => {
          if (!paused) next();
        }, 4000);
      }

      function stop() {
        if (timer) clearInterval(timer);
        timer = null;
      }

      buildGallery(currentImagesForVariant(defaultVariant));
      start();
      window.addEventListener('beforeunload', stop);

      const flavourSelect = document.getElementById('ppFlavourSelect');
      const selectedFlavourText = document.getElementById('ppSelectedFlavour');
      const sizeSelect = document.getElementById('ppSizeSelect');
      const selectedSizeText = document.getElementById('ppSelectedSize');
      const addBtn = document.querySelector('.pp-add.add-to-cart');

      function applyVariant(variantKey, selectedTextEl, selectedPrefix) {
        const variant = flavourConfig[variantKey];
        if (!variant || !addBtn) return;

        addBtn.dataset.variant = variant.label;
        addBtn.dataset.name = variant.cart_name;
        addBtn.dataset.image = variant.image;

        if (selectedTextEl) {
          selectedTextEl.textContent = `${selectedPrefix}: ${variant.label}`;
        }

        stop();
        buildGallery(currentImagesForVariant(variantKey));
        start();
      }

      if ((isWhey || isCreatine || isPreWorkout || isBcaa) && flavourSelect) {
        flavourSelect.addEventListener('change', () => {
          applyVariant(flavourSelect.value, selectedFlavourText, 'Selected flavour');
        });

        applyVariant(flavourSelect.value, selectedFlavourText, 'Selected flavour');
      }

      if (isClothing && sizeSelect) {
        sizeSelect.addEventListener('change', () => {
          applyVariant(sizeSelect.value, selectedSizeText, 'Selected size');
        });

        applyVariant(sizeSelect.value, selectedSizeText, 'Selected size');
      }
    });

    const qtyWrap = document.querySelector('.pp-qty');
    const qtyInput = document.querySelector('.pp-qty-input');
    const addBtn = document.querySelector('.pp-add.add-to-cart');

    if (qtyWrap && qtyInput && addBtn && !addBtn.disabled) {
      const clampQty = (n) => {
        const v = Number.isFinite(n) ? n : 1;
        return Math.max(1, Math.floor(v));
      };

      const sync = () => {
        addBtn.dataset.qty = String(clampQty(parseInt(qtyInput.value || '1', 10)));
      };

      qtyWrap.addEventListener('click', (e) => {
        const btn = e.target.closest('.pp-qty-btn');
        if (!btn) return;

        const delta = btn.dataset.qty === '+1' ? 1 : -1;
        const current = clampQty(parseInt(qtyInput.value || '1', 10));
        qtyInput.value = String(clampQty(current + delta));
        sync();
      });

      qtyInput.addEventListener('input', sync);
      qtyInput.addEventListener('change', sync);

      addBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopImmediatePropagation();

        if (!window.Cart || typeof window.Cart.addItem !== 'function') return;

        const id = addBtn.dataset.id;
        const name = addBtn.dataset.name;
        const price = parseFloat(addBtn.dataset.price || '0') || 0;
        const image = addBtn.dataset.image || '';
        const qty = clampQty(parseInt(addBtn.dataset.qty || '1', 10));
        const variant = addBtn.dataset.variant || '';

        for (let i = 0; i < qty; i++) {
          window.Cart.addItem(id, name, price, image, { variant });
        }

        const cartDisplay = document.getElementById('cartDisplay');
        if (cartDisplay && window.Cart.getCount) {
          cartDisplay.textContent = `Cart (${window.Cart.getCount()})`;
        }

        window.dispatchEvent(new CustomEvent('pp:cartUpdated'));
      }, true);

      sync();
    }

    const sizeGuideModal = document.getElementById('ppSizeGuideModal');
    const sizeGuideOpen = document.getElementById('ppSizeGuideOpen');
    const sizeGuideClose = document.getElementById('ppSizeGuideClose');
    const sizeGuideBackdrop = document.querySelector('[data-size-guide-close]');

    if (sizeGuideModal && sizeGuideOpen) {
      const openSizeGuide = () => {
        sizeGuideModal.classList.add('is-open');
        sizeGuideModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
      };

      const closeSizeGuide = () => {
        sizeGuideModal.classList.remove('is-open');
        sizeGuideModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
      };

      sizeGuideOpen.addEventListener('click', openSizeGuide);
      sizeGuideClose?.addEventListener('click', closeSizeGuide);
      sizeGuideBackdrop?.addEventListener('click', closeSizeGuide);

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sizeGuideModal.classList.contains('is-open')) {
          closeSizeGuide();
        }
      });
    }
  });
</script>
@endsection