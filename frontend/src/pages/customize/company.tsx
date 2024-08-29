import Box from '@mui/material/Box'
import Button from '@mui/material/Button'
import Card from '@mui/material/Card'
import CardContent from '@mui/material/CardContent'
import Checkbox from '@mui/material/Checkbox'
import Container from '@mui/material/Container'
import List from '@mui/material/List'
import ListItem from '@mui/material/ListItem'
import ListItemButton from '@mui/material/ListItemButton'
import ListItemText from '@mui/material/ListItemText'
import Typography from '@mui/material/Typography'
import { useRouter } from 'next/router'
import { useState, useEffect } from 'react'
import { ky } from '@/libs/ky'

type Company = {
  id: number
  name: string
}

export default function CompanyList() {
  const [companyData, setCompanyData] = useState<Company[]>([])
  const [selectedCompanies, setSelectedCompanies] = useState<number[]>([])
  const [itemsToShow, setItemsToShow] = useState(15) // 表示するアイテム数の初期値を15に設定

  const router = useRouter()

  useEffect(() => {
    if (!router.isReady) return;

    const raw_industry_id = router.query['industry-id']
    if (!raw_industry_id) {
      router.push('/customize/industry').then()
      return
    }

    const industry_ids = Array.isArray(raw_industry_id)
      ? raw_industry_id
      : [raw_industry_id]

    const searchParams = new URLSearchParams()
    industry_ids.forEach((industry_id) => {
      searchParams.append('industry_ids[]', industry_id)
    })

    ky.get('./api/company/list', {
      searchParams,
    })
      .then((v) => {
        return v.json<
          {
            id: number
            name: string
          }[]
        >()
      })
      .then((value) => {
        setCompanyData(value)
      })
  }, [router, router.query])

  const handleToggle = (value: number) => {
    const currentIndex = selectedCompanies.indexOf(value)
    const newChecked = [...selectedCompanies]

    if (currentIndex === -1) {
      newChecked.push(value)
    } else {
      newChecked.splice(currentIndex, 1)
    }

    setSelectedCompanies(newChecked)
  }

  const handleLoadMore = () => {
    setItemsToShow(itemsToShow + 15) // さらに15件を表示
  }

  const handleSubmit = async () => {
    try {
      const response = await fetch('http://localhost:8000/test', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          selectedCompanies,
        }),
      })

      if (!response.ok) {
        return
      }

      const data = await response.json()
      console.log(data)
      alert('Submission successful')
    } catch (error) {
      console.error('Failed to submit companies:', error)
      alert('Failed to submit')
    }
  }

  return (
    <Box sx={{ backgroundColor: 'white', minHeight: '100vh', p: 4 }}>
      <Typography
        variant="h3"
        component="h1"
        sx={{ textAlign: 'center', mb: 2 }}
      >
        オススメ会社一覧
      </Typography>
      <Typography
        variant="body1"
        component="p"
        sx={{ textAlign: 'center', mb: 4 }}
      >
        あなたが気になる会社を選ぼう
      </Typography>
      <Container maxWidth="md">
        <List
          sx={{ width: '100%', bgcolor: 'background.paper', overflow: 'auto' }}
        >
          {companyData.slice(0, itemsToShow).map((company) => (
            <Card key={company.id} sx={{ mb: 4, p: 2 }}>
              <CardContent>
                <ListItem disablePadding>
                  <ListItemButton
                    role={undefined}
                    onClick={() => handleToggle(company.id)}
                    dense
                  >
                    <Checkbox
                      edge="start"
                      checked={selectedCompanies.indexOf(company.id) !== -1}
                      tabIndex={-1}
                      disableRipple
                    />
                    <ListItemText
                      primary={company.name}
                      sx={{ textAlign: 'center' }}
                      primaryTypographyProps={{ variant: 'h6' }}
                    />
                  </ListItemButton>
                </ListItem>
              </CardContent>
            </Card>
          ))}
        </List>
        {itemsToShow < companyData.length && (
          <Box sx={{ display: 'flex', justifyContent: 'center', mt: 4 }}>
            <Button
              variant="contained"
              color="primary"
              onClick={handleLoadMore}
            >
              もっと見る
            </Button>
          </Box>
        )}
        <Box sx={{ display: 'flex', justifyContent: 'center', mt: 4 }}>
          <Button variant="contained" color="primary" onClick={handleSubmit}>
            提出
          </Button>
        </Box>
      </Container>
    </Box>
  )
}
