<?php

namespace App\Traits;

use Dompdf\Dompdf;

trait PdfGenerator
{
    public function genrateDomPdf($html, $page)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', $page);
         $dompdf->render();
        $mainContentPdf = $dompdf->output();
        $filename = "project" . uniqid() . "ab.pdf";
        $filePath = storage_path('app/pdf') . "/" . $filename;

        file_put_contents($filePath, $mainContentPdf);
        return $filePath;
    }

    public function drawDigarm($decks)
    {
        $i = 1;
        $html = "";
        $lineCss = 'position:absolute;background-color:#4052d6;border:solid #4052d6 1px;';
        $tooltipCss = 'position: absolute;background-color: #fff;border: 1px solid #4052d6;padding: 1px;border-radius: 2px;
                white-space: nowrap;z-index: 1;color:#4052d6;font-size:8px;text-align:center;';
        if (count($decks['checks']) > 0) {
            $chunks = array_chunk($decks['checks']->toArray(), 8);
         
            $k = 0;
            $gap = 1;
            $ori = "landscape";
            $oddincreaseGap = 18;
            $evenincreaseGap = 29;
            $imageDesireHeight = 400;
            foreach ($chunks as $chunkIndex => $chunk) {
                $imagePath = $decks['image'];
                $imageData = base64_encode(file_get_contents($imagePath));
                $imageBase64 = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;
                list($width, $height) = getimagesize($imagePath);
                $containerWidth = "1024"; 
                if ($width >= 1000) {
                    $html .= "<div class='maincontnt next' style='display: flex; justify-content: center; align-items: center; flex-direction: column; height:100vh;'>";
                } else {
                    if ($height >= 380) {
                        $ori = "portrait";
                        if($width >= 500){
                            $containerWidth = "794";

                        }else{
                            $containerWidth = "900";

                        }
                        $image_height =  $imageDesireHeight;
                        $image_width = ($image_height * $width) / $height;
                    } else {
                        $image_width = $width;
                    }
                   
                    $leftPositionPixels = ($containerWidth - $image_width) / 2;
                    $leftPositionPercent = ($leftPositionPixels / 1024) * 100;

                    $html .= "<div class='maincontnt next' style='display: flex; justify-content: center; align-items: center; flex-direction: column;margin-left:{$leftPositionPercent}%;'>";
                }
                $topPer =  ( $ori == 'portrait') ? '40%':'20%';

                $html .= '<div style="margin-top:'.$topPer.';">';

                $html .= '<div class="image-container " id="imgc' . $i . '" style="position: relative;width: 100%; ">';
                $image_width  = 1024;

                if ($width > 1000) {
                    $image_height = ($image_width * $height) / $width;

                    $newImage = '<img src="' . $imageBase64 . '" id="imageDraw' . $i . '" style="width:' .  $image_width . 'px;" />';
                } else {
                    if ($height >= 380) {
                       $image_height =$imageDesireHeight;
                        $image_width = ($image_height * $width) / $height;
                        $newImage = '<img src="' . $imageBase64 . '" id="imageDraw' . $i . '"  style="width:' .  $image_width . 'px;"/>';
                    } else {
                        $image_height = $height;
                        $newImage = '<img src="' . $imageBase64 . '" id="imageDraw' . $i . '" />';
                    }
                }
                $html .= $newImage;
                $evenarrayLeft = [];
                $evenarrayTop = [];
                $sameLocationevenarray = [];
                $sameLocationoddarray = [];

                $oddarrayLeft = [];
                $oddarrayTop = [];

                $maxLine = ''; // Optional: to store the longest tooltip text
                $maxLength = 0; // Variable to store the max tooltip length
                $chunkcount = 0;
                foreach ($chunk as $key => $value) {
                    $chunkcount++;
                    if($chunkcount == 1){
                        $oddincreaseGap = 18;
                    }
                    $top = $value['position_top'];
                    $left = $value['position_left'];

                   
                    $tooltipText = ($value['type'] == 'sample' ? 's' : 'v') . $value['name'] . "<br/>";
                    if (@$value['check_hazmats']) {
                        $hazmatCount = count($value['check_hazmats']); // Get the total number of elements
                        foreach ($value['check_hazmats'] as $index => $hazmet) {
                            $tooltipText .= '<span style="font-size:14px;color:' . $hazmet['hazmat']['color']   . '">' . $hazmet['hazmat']['short_name'] . '</span>';
                            if ($index < $hazmatCount - 1) {
                                $tooltipText .= ',';
                            }
                        }
                    }
                    $currentLength = strlen(strip_tags($tooltipText)); // Remove HTML tags for length calculation
                    if ($currentLength > $maxLength) {
                        $maxLength = $currentLength;
                    }
                    $k++;
                    if ($width > 1000 || $height >= 600) {
                        $topshow = ($image_width * $top) / $width;
                        $leftshow = ($image_width * $left) / $width;
                    } else {

                        if ($image_height == $imageDesireHeight) {
                            $topshow = ($image_width * $top) / $width;
                            $leftshow = ($image_width * $left) / $width;
                        } else {
                            $topshow = $top;
                            $leftshow = $left;
                        }
                    }
                    $lineLeftPosition =  ($leftshow + 4);
                    $tool = 0;
                    if ($k % 2 == 1) {
                        $lineTopPosition = "-" . $gap;
                        $lineHeight = ($topshow + $gap);
                        $tooltipStart = $lineTopPosition - $oddincreaseGap;
                        $oddsameLocation = 0;
                        foreach ($oddarrayLeft as $key => $oddvalue) {
                            if (abs($lineLeftPosition - $oddvalue) < 100 && abs($topshow - $oddarrayTop[$key]) < 100) {
                                $oddsameLocation++;
                                $tooltipStart = $tooltipStart - $oddincreaseGap;
                                $lineHeight = $lineHeight + $oddincreaseGap;
                                $lineTopPosition = $lineTopPosition - $oddincreaseGap;
                            } else {
                                //for else odd i mean line in same place
                                $tooltipStart = $tooltipStart - 29;
                                $lineHeight =  $topshow +  abs($tooltipStart);
                                $lineTopPosition = $tooltipStart;
                            }
                        }
                        if ($oddsameLocation > 1) {
                            foreach ($sameLocationoddarray as $sameLocationoddValue) {
                                if ($sameLocationoddValue == $tooltipStart) {
                                    $tooltipStart = $tooltipStart - 29;
                                    $lineHeight =  $topshow +  abs($tooltipStart);
                                    $lineTopPosition = $tooltipStart;
                                }
                            }
                            $sameLocationoddarray[] = $tooltipStart;
                        }
                        $oddarrayLeft[$value['id']] =  $lineLeftPosition;
                        $oddarrayTop[$value['id']] =  $topshow;
                    } else {
                        $lineTopPosition =   $topshow;
                        $lineHeight = ($image_height - $topshow + $gap);
                        $tooltipStart = $image_height + $gap;
                        $sameLocation = 0;
                        $findLeft = abs($maxLength * 5 + 100);
                    

                        foreach ($evenarrayLeft as $key => $evenvalue) {
                            if (abs($lineLeftPosition - $evenvalue) < $findLeft && abs($topshow - $evenarrayTop[$key]) < 100) {
                                $sameLocation++;
                                $tooltipStart = $tooltipStart + $evenincreaseGap;
                                $lineHeight = $lineHeight + $evenincreaseGap;
                            }else{
                                
                                    $tooltipStart = $tooltipStart  + $evenincreaseGap; // Example of subtracting for odd
                                    $lineHeight = $lineHeight + $evenincreaseGap ;    // Adjust this logic as per your needs
                                
                            }
                        }
                       
                        if ($sameLocation > 1) {
                            foreach ($sameLocationevenarray as $sameLocationValue) {
                                if ($sameLocationValue == $tooltipStart) {
                                    $tooltipStart = $tooltipStart +  $evenincreaseGap;
                                    $lineHeight = $lineHeight +  $evenincreaseGap;
                                }
                            }
                            $sameLocationevenarray[] = $tooltipStart;
                        }
                        $evenarrayLeft[$value['id']] = $lineLeftPosition;
                        $evenarrayTop[$value['id']] =  $topshow;
                    }
                     $html .= '<div class="dot" style="top:' . $topshow . 'px; left:' . $leftshow . 'px; position: absolute;border: 4px solid #4052d6;background: #4052d6;border-radius: 50%;"></div>';

                     $html .= '<span class="line" style="top:' . $lineTopPosition  . 'px;left:' . $lineLeftPosition . 'px;height:' . $lineHeight . 'px;' . $lineCss . '"></span>';


                     $html .= '<span class="tooltip" style="' . $tooltipCss . 'top:' . $tooltipStart . 'px; left:' . ($lineLeftPosition - 15) . 'px">' . $tooltipText . '</span>';
                }
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';

                $i++; // Increment the counter for the next image ID

            }
        }


        return ['html'=>$html,'ori'=>$ori];
    }
}
