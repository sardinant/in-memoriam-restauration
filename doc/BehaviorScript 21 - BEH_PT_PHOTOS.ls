property pSprite, pState, pBlinkV, pCast, pMemberNum, pValue, pNumPhoto, pBlend, pNextMember
global g, gL, gSp

on beginSprite me
  pSprite = sprite(me.spriteNum)
  pState = #wait
  pCast = pSprite.member.castLibNum
  pMemberNum = pSprite.memberNum
  pNumPhoto = 1
  pBlend = 100.0
  if g[#SQUARRELST] = VOID then
    g.addProp(#SQUARRELST, [])
  end if
  g[#SQUARRELST].add(pSprite)
  pValue = chars(pSprite.member.name, 6, 7)
  gSpAdd(symbol("SQUARRE_" & pValue), pSprite)
end

on mouseEnter me
  if not gSp.GAME.pSquarreActif then
    exit
  end if
  if (pNumPhoto < 3) and (pState = #wait) and (pNumPhoto = gSp.GAME.pNumImage) then
    pNextMember = pMemberNum + (80 * pNumPhoto)
    pState = #BLENDTO0
  end if
end

on prepareFrame me
  if gAskBusy() then
    case pState of
      #wait:
      #BLENDTO0:
        if pBlend > 0 then
          pBlend = max(0, pBlend - (200 * g.frameTime))
          pSprite.blend = pBlend
        else
          pSprite.member = member(pNextMember, pCast)
          pNumPhoto = pNumPhoto + 1
          pState = #BLENDTO100
          vNum = ((pSprite.locH - 199) / 47) + 1
          gSp.GAME.mDelAPhoto(vNum)
        end if
      #BLENDTO100:
        if pBlend < 100 then
          pBlend = min(100, pBlend + (200 * g.frameTime))
          pSprite.blend = pBlend
        else
          pState = #wait
        end if
      #WHITEFLASH:
        pSprite.blend = min(100, pSprite.blend + (g.frameTime * 200))
        if pSprite.blend = 100 then
          pState = #wait
        end if
      #BLINK:
        vNewBlend = pSprite.blend + (pBlinkV * g.frameTime * 600)
        pSprite.blend = max(0, min(100, vNewBlend))
        if pSprite.blend = 0 then
          if pSprite.memberNum = pNextMember then
            pSprite.member = member(pNextMember + 80, pCast)
          end if
          pBlinkV = 1.0
        else
          if pSprite.blend = 100 then
            pBlinkV = -1.0
          end if
        end if
    end case
  end if
end

on bWhiteFlash me
  pSprite.blend = 0
  pState = #WHITEFLASH
end

on bBlink me
  pBlinkV = -1.0
  pState = #BLINK
end

on bBlinkOff me
  pSprite.member = member(pNextMember, pCast)
  pSprite.blend = 100
  pState = #wait
end
