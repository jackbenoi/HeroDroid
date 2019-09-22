<script type="application/ld+json">{
    "@context": "http://schema.org",
    "@type": "Review",
    "itemReviewed": {
        "@type": "Thing",
        "name": "{{ $detail->title }}"
    },
    "reviewRating": {
        "@type": "Rating",
        "ratingValue": "{{ $detail->ratings }}",
        "bestRating": "{{ $detail->ratings }}",
        "worstRating": "1"
    },
    "name": "{{ $detail->title }}",
    "author": {
        "@type": "Person",
        "name": "{{ @$configuration['site_author'] }}"
    },
    "reviewBody": "{{ truncate(@$detail->description,150) }}",
    "datePublished": "{{ $detail->published_date }}",
    "publisher": {
        "@type": "Organization",
        "name": "{{ @$configuration['site_author'] }}"
    }
}</script>